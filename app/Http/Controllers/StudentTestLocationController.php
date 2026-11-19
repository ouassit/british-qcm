<?php

namespace App\Http\Controllers;

use App\Models\UserPageConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StudentTestLocationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string|max:2048',
            'location_status' => 'required|in:granted,denied,unavailable,timeout',
            'latitude' => 'required_if:location_status,granted|nullable|numeric|between:-90,90',
            'longitude' => 'required_if:location_status,granted|nullable|numeric|between:-180,180',
            'accuracy' => 'required_if:location_status,granted|nullable|numeric|min:0|max:100000000',
        ]);
        try {
            $payload = json_decode(Crypt::decryptString($data['token']), true);
            abort_unless(is_array($payload) && isset($payload['id'], $payload['expires']) && $payload['expires'] >= time(), 403);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403);
        }
        $connection = UserPageConnection::where('user_id', $request->user()->id)
            ->where('page', '/students_tests')->findOrFail($payload['id']);
        $connection->location_status = $data['location_status'];
        foreach (['latitude', 'longitude', 'accuracy'] as $field) {
            $connection->$field = $data['location_status'] === 'granted' ? $data[$field] : null;
        }
        $connection->save();
        return response()->json(['success' => true]);
    }
}
