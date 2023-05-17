<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        foreach($wards as $ward) {
            Ward::factory()->create([
                'ward_no' => $ward['ward_no'],
                'ward_name' => $ward['ward_name'],
            ]);
        }
    }

    public function getWardsArray() {
        return [
            array('ward_no' => 1, 'ward_name' => 'Halapitiya'),
            array('ward_no' => 2, 'ward_name' => 'Godigamuwa'),
            array('ward_no' => 3, 'ward_name' => 'Palannoruwa'),
            array('ward_no' => 4, 'ward_name' => 'Oluboduwa'),
        ];
    }
}