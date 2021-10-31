<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (empty(App\Models\Role::where('roleName', 'Organization')->get()->first())) {
            DB::table('roles')->updateOrInsert([
                'roleName' => 'Organization',
                'roleType' => 'Organization',
                'permissions' => '["dashboardread","menuadmin\/dashboard"]',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }

    }
}
