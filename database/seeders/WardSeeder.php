<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Data\WardData;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $wards = $this->getWardsArray();

        foreach ($wards as $ward) {
            Ward::factory()->create([
                'ward_no' => $ward['ward_no'],
                'ward_name' => $ward['ward_name'],
            ]);
        }
    }

    public function getWardsArray()
    {
        return WardData::$ward_data;
    }
}
