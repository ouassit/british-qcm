<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Support\DemoAccountSeeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique(User::class)],
            'name' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'username' => strtolower($input['username']),
                'name' => $input['name'],
                'email' => $input['email'],
                'telephone' => $input['telephone'],
                'company' => $input['company'],
                'password' => Hash::make($input['password']),
                'expire_date' => Carbon::today()->addMonth(),
                'export_test' => 0,
                'super_admin' => 0,
            ]);

            DemoAccountSeeder::seed($user);

            return $user;
        });
    }
}
