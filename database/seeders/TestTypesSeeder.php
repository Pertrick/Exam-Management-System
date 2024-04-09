<?php

namespace Database\Seeders;

use App\Models\TestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!TestType::exists()) {
            $testTypes = ['mock', 'exam'];
            foreach ($testTypes as $testType) {
                TestType::create([
                    'name' => $testType
                ]);
            }
        }
    }
}
