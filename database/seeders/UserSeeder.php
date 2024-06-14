<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role
        $role = Role::first();

        $admin = Admin::firstOrCreate(
            ['email' => 'developer@mail.com'],
            [
                'name' => 'Zakir Soft',
                'image' => 'backend/image/default-user.png',
                'password' => bcrypt('password@12345'),
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]
        );
        $admin->assignRole($role);

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'image' => 'backend/image/default-user.png',
                'password' => bcrypt('password'),
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]
        );
        $admin->assignRole($role);

        // customer
        $user = User::firstOrCreate(
            ['email' => 'customer@mail.com'],
            [
                'name' => 'Customer',
                'username' => 'customer',
                'phone' => '01234567891',
                'web' => 'https://demo.com',
                'address' => 'Flor: 4, House: 34/4, Road: 3, Block: A, Dhaka Uddan, Mohammadpur, Dhaka 1207',
                'bio' => 'As an Adlisting user, I effortlessly showcase and sell products, connecting with buyers for successful transactions.',
                'password' => bcrypt('password'),
                'email_verified_at' => Carbon::now(),
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'johnwick@mail.com'],
            [
                'name' => 'John Wick',
                'username' => 'johnwick',
                'phone' => '01234567892',
                'web' => 'https://demo1.com',
                'address' => 'Flor: 4, House: 34/4, Road: 3, Block: A, Dhaka Uddan, Mohammadpur, Dhaka 1207',
                'bio' => 'As an Adlisting user, I effortlessly showcase and sell products, connecting with buyers for successful transactions.',
                'password' => bcrypt('password'),
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'johndoe@mail.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'phone' => '0123456789',
                'web' => 'https://demo2.com',
                'address' => 'Flor: 4, House: 34/4, Road: 3, Block: A, Dhaka Uddan, Mohammadpur, Dhaka 1207',
                'bio' => 'As an Adlisting user, I effortlessly showcase and sell products, connecting with buyers for successful transactions.',
                'password' => bcrypt('password'),
            ]
        );
    }
}
