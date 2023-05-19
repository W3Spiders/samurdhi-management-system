<?php

namespace Database\Seeders;

use App\Models\GNDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GnDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gn_divisions = $this->getGnDivisions();

        foreach($gn_divisions as $gn_division) {
            GNDivision::factory()->create([
                'ward_no' => $gn_division['ward_no'],
                'gn_division_no' => $gn_division['gn_division_no'],
                'gn_division_name' => $gn_division['gn_division_name'],
            ]);
        }
    }

    public function getGnDivisions() {
        return [
            array(
                'ward_no' => 1, 
                'gn_division_no' => '606A',
                'gn_division_name' => 'Welmilla'
            ),
            array(
                'ward_no' => 1, 
                'gn_division_no' => '606C',
                'gn_division_name' => 'Halapitiya'
            ),
           
        ];
    }
}