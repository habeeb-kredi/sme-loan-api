<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $roles = [
           Role::create(
            ['role'=>'Admin']
         ),
            Role::create(
                ['role'=>'Financial Analyst']
            )
        ];
       for($i=0; $i<count($roles); $i++){
           $roles[$i];
       }
    }
}
