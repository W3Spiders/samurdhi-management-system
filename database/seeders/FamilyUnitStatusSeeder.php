<?php

namespace Database\Seeders;

use App\Models\FamilyUnitStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyUnitStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_list = [
            ['status_code' => 'new', 'status_title' => 'New'],
            ['status_code' => 'pending_approval', 'status_title' => 'Pending Approval'],
            ['status_code' => 'approved', 'status_title' => 'Approved'],
            ['status_code' => 'rejected', 'status_title' => 'Rejected']
        ];

        foreach($status_list as $status) {
            FamilyUnitStatus::factory()->create([
                'status_code' => $status['status_code'],
                'status_title' => $status['status_title']
            ]);
        }
    }
}