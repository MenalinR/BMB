<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:make-admin', function () {
    $email = $this->ask('Email address (used to log in)');
    $user = User::where('email', $email)->first();

    $name = $user?->name ?? $this->ask('Name');
    $password = $this->secret($user ? 'New password (leave empty to keep the current one)' : 'Password (at least 8 characters)');

    $validator = Validator::make(
        ['email' => $email, 'name' => $name, 'password' => $password],
        [
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
        ],
    );

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return 1;
    }

    $user ??= new User(['email' => $email]);
    $user->name = $name;
    if ($password) {
        $user->password = $password;
    }
    $user->is_admin = true;
    $user->save();

    $this->info("{$email} can now log in and manage the shop at /admin.");

    return 0;
})->purpose('Create an admin account, or make an existing user an admin');
