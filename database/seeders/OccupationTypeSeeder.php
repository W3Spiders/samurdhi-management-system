<?php

namespace Database\Seeders;

use App\Models\OccupationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationTypeSeeder extends Seeder
{

    public $occupation_types = [
        'None', 'Government', 'Private', 'Self-Emplyed'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->occupation_types as $type) {
            OccupationType::factory()->create([
                'name' => $type
            ]);
        }
    }


}