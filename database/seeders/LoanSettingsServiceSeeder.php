<?php

namespace Database\Seeders;

use App\Models\LoanSetting;
use Illuminate\Database\Seeder;

class LoanSettingsServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanSetting::create([
            "loan_product_id"=>2,
            "interest"=>5
        ]);
    }
}
