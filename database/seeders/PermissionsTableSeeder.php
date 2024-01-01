<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'team_create',
            ],
            [
                'id'    => 18,
                'title' => 'team_edit',
            ],
            [
                'id'    => 19,
                'title' => 'team_show',
            ],
            [
                'id'    => 20,
                'title' => 'team_delete',
            ],
            [
                'id'    => 21,
                'title' => 'team_access',
            ],
            [
                'id'    => 22,
                'title' => 'benefit_category_create',
            ],
            [
                'id'    => 23,
                'title' => 'benefit_category_edit',
            ],
            [
                'id'    => 24,
                'title' => 'benefit_category_show',
            ],
            [
                'id'    => 25,
                'title' => 'benefit_category_delete',
            ],
            [
                'id'    => 26,
                'title' => 'benefit_category_access',
            ],
            [
                'id'    => 27,
                'title' => 'benefit_create',
            ],
            [
                'id'    => 28,
                'title' => 'benefit_edit',
            ],
            [
                'id'    => 29,
                'title' => 'benefit_show',
            ],
            [
                'id'    => 30,
                'title' => 'benefit_delete',
            ],
            [
                'id'    => 31,
                'title' => 'benefit_access',
            ],
            [
                'id'    => 32,
                'title' => 'employee_create',
            ],
            [
                'id'    => 33,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 34,
                'title' => 'employee_show',
            ],
            [
                'id'    => 35,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 36,
                'title' => 'employee_access',
            ],
            [
                'id'    => 37,
                'title' => 'country_create',
            ],
            [
                'id'    => 38,
                'title' => 'country_edit',
            ],
            [
                'id'    => 39,
                'title' => 'country_show',
            ],
            [
                'id'    => 40,
                'title' => 'country_delete',
            ],
            [
                'id'    => 41,
                'title' => 'country_access',
            ],
            [
                'id'    => 42,
                'title' => 'province_create',
            ],
            [
                'id'    => 43,
                'title' => 'province_edit',
            ],
            [
                'id'    => 44,
                'title' => 'province_show',
            ],
            [
                'id'    => 45,
                'title' => 'province_delete',
            ],
            [
                'id'    => 46,
                'title' => 'province_access',
            ],
            [
                'id'    => 47,
                'title' => 'report_create',
            ],
            [
                'id'    => 48,
                'title' => 'report_edit',
            ],
            [
                'id'    => 49,
                'title' => 'report_show',
            ],
            [
                'id'    => 50,
                'title' => 'report_delete',
            ],
            [
                'id'    => 51,
                'title' => 'report_access',
            ],
            [
                'id'    => 52,
                'title' => 'variant_create',
            ],
            [
                'id'    => 53,
                'title' => 'variant_edit',
            ],
            [
                'id'    => 54,
                'title' => 'variant_show',
            ],
            [
                'id'    => 55,
                'title' => 'variant_delete',
            ],
            [
                'id'    => 56,
                'title' => 'variant_access',
            ],
            [
                'id'    => 57,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
