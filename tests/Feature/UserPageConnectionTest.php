<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserPageConnection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
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
        $this->get('/students_tests')->assertOk()->assertDontSee('Partager ma localisation')->assertDontSee('students_tests_location.js');
        $this->assertSame($count + 1, UserPageConnection::count());
        $this->assertDatabaseHas('student_test_connections', [
            'user_id' => $user->id, 'page' => '/students_tests', 'ip_address' => '127.0.0.1',
        ]);
    }

    public function test_location_sharing_route_is_removed()
    {
        $this->assertFalse(Route::has('students_tests.location'));
        $this->actingAs(User::firstOrFail())->postJson('/students_tests/location', [
            'location_status' => 'granted',
            'latitude' => 33.5731,
            'longitude' => -7.5898,
            'accuracy' => 30,
        ])->assertStatus(405);
    }
}
