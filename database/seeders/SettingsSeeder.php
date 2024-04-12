<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Setting::first()){
            Setting::create([
                'site_name' => 'Exam Management System',
                'primary_color' => '#162239fc',
                'secondary_color' => '#58e8f280',
                'main' => '#ffffff'
            ]);
        }
    }
}
