<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SimpleAuthController extends Controller
{
    private $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function simpleLogin(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, $this->rules);
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }

            $user = User::where('username', $input['username'])->firstOrFail();
            if ($user && Hash::check($request->password, $user->password))
            {
                return response()->json($user, 200);
            }

            return response()->json('Credentials issue', 401);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }
}
