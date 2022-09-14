<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\PublicTreasury;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'id'             => 1,
                'title'          => 'المدير العام',
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'title'          => 'مدير فرع',
                'created_at'     => now(),
            ],
        ];

        Role::insert($role);
        $account = [
            [
                'id'             => 1,
                'name'           => 'الفرع الرئيسي',
                'details'       => 'تفاصيل الفرع',
                'status'         => 1,
                'created_at'     => now(),
            ],
        ];

        Account::insert($account);
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'role_id'        => 1,
                'account_id'     => 1,
                'created_at'     => now(),
            ],
        ];

        User::insert($users);

    }
}
