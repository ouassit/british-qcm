<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserPageConnection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class UserPageConnectionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_only_the_management_page_records_a_visit()
    {
        $user = User::firstOrFail();
        $count = UserPageConnection::count();
        $this->actingAs($user)->get('/test')->assertOk();
        $this->assertSame($count, UserPageConnection::count());
        $this->get('/students_tests')->assertOk()->assertSee('Partager ma localisation');
        $this->assertSame($count + 1, UserPageConnection::count());
        $this->assertDatabaseHas('student_test_connections', [
            'user_id' => $user->id, 'page' => '/students_tests', 'ip_address' => '127.0.0.1',
        ]);
    }

    public function test_location_is_attached_to_the_authenticated_users_visit()
    {
        $user = User::firstOrFail();
        $connection = UserPageConnection::create(['user_id' => $user->id, 'page' => '/students_tests', 'ip_address' => '127.0.0.1']);
        $token = Crypt::encryptString(json_encode(['id' => $connection->id, 'expires' => time() + 60]));
        $this->actingAs($user)->postJson('/students_tests/location', [
            'token' => $token, 'location_status' => 'granted',
            'latitude' => 33.5731, 'longitude' => -7.5898, 'accuracy' => 30,
            'ip_address' => '8.8.8.8',
        ])->assertOk();
        $connection->refresh();
        $this->assertEquals(33.5731, $connection->latitude);
        $this->assertSame('127.0.0.1', $connection->ip_address);
        $connection->user_id = $user->id + 1000000;
        $connection->save();
        $this->postJson('/students_tests/location', ['token' => $token, 'location_status' => 'denied'])->assertNotFound();
    }

    public function test_guests_cannot_record_location()
    {
        $this->postJson('/students_tests/location', ['token' => 'invalid', 'location_status' => 'denied'])->assertUnauthorized();
    }

    public function test_invalid_coordinates_and_expired_tokens_are_rejected()
    {
        $this->actingAs(User::firstOrFail())->postJson('/students_tests/location', [
            'token' => 'invalid', 'location_status' => 'granted',
            'latitude' => 91, 'longitude' => -181, 'accuracy' => -1,
        ])->assertStatus(422);
        foreach (['invalid', Crypt::encryptString(json_encode(['id' => 1, 'expires' => time() - 60]))] as $token) {
            $this->postJson('/students_tests/location', ['token' => $token, 'location_status' => 'denied'])->assertForbidden();
        }
    }
}
