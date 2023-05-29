<?php

namespace Database\Seeders;

use App\Models\FamilyUnit;
use App\Models\Member;
use App\Models\OccupationType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{

    private $occupation_types = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $familyUnits = FamilyUnit::all();

        $this->occupation_types = OccupationType::all();

        // Iterate number of family units
        for ($familyUnitId = 1; $familyUnitId <= count($familyUnits); $familyUnitId++) {

            // Iterate number of members that this family unit owns
            for ($j = 1; $j <= 4; $j++) {

                $this->createSingleMember($familyUnitId);
            }
        }
    }

    public function createSingleMember($familyUnitId)
    {

        $birthday = Carbon::create(fake()->dateTimeBetween('-70 years', '-12 years'));
        $birthdayString = $birthday->toDateString(); // 1999-01-01
        $birthdayFirst4Digits = substr($birthdayString, 0, 4); // Remove '-' chars

        $is_adult = $birthday->diffInYears(Carbon::now()) >= 18;
        $nic = null;
        $maritalStatus = null;

        // Create NIC for people more than 16 years old.
        if ($birthday->diffInYears(Carbon::now()) > 16) {
            $nic = $birthdayFirst4Digits . fake()->randomNumber(8, true);
        }

        // Select marital status randomly only for people more than 18 years old.
        if ($is_adult) {
            $maritalStatus = fake()->randomElement(['single', 'married']);
        } else {
            $maritalStatus = 'single';
        }

        // Select a random gender
        $gender = fake()->randomElement(['m', 'f']);

        // Generate first name according to the gender
        $firstName = $gender == 'm' ? fake()->firstNameMale() : fake()->firstNameFemale();

        // Randomly generate middle name or not
        $middleName = fake()->randomElement([0,1]) == 0 ? null : fake()->firstName();

        // Randomly select has income
        // $hasIncome = fake()->randomElement(['0','1']);

        $occupation = $this->get_random_occupation($is_adult);

        // Monthly income according to the hasIncome value
        $monthlyIncome = $occupation['occupation_type_id'] == 1 ? null : fake()->numberBetween(5000, 50000);

        Member::factory()->create([
            'family_unit_id' => $familyUnitId,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => fake()->lastName(),
            'birthday' => $birthday,
            'nic'=> $nic,
            'email' => fake()->email(),
            'phone' => $this->randomPhoneNumber(),
            'monthly_income' => $monthlyIncome,
            'marital_status' => $maritalStatus,
            'gender' => $gender,
            'occupation_type_id' => $occupation['occupation_type_id'], 
            'occupation' => $occupation['occupation_name']
        ]);
    }

    public function get_random_occupation(bool $is_adult) {
        
        $occupation = [
            'occupation_type_id' => null,
            'occupation_name' => null,
        ];

        if (!$is_adult) {
            // Set occupation_type = null
            $occupation['occupation_type_id'] = $this->occupation_types[0]->id;
            $occupation['occupation_name'] = $this->occupation_types[0]->name;
            
        } else {
            
            $selected_occupation_type = fake()->randomElement($this->occupation_types);

            $occupation['occupation_type_id'] = $selected_occupation_type->id;

            // Set occupation name if only selected an occupation except 'None'
            if (strtolower($selected_occupation_type->name) != 'none') {
                $occupation['occupation_name'] = fake()->jobTitle();
            }
        }

        return $occupation;
    }

    public function randomPhoneNumber() {

        $generalPhoneNumber = fake()->phoneNumber();

        $phoneNumber = $this->removeChars($generalPhoneNumber, ['-','(',')',' ', '+', '.']);

        $phoneNumber = substr($phoneNumber, 0, 10);

        return $phoneNumber;

    }

    private function removeChars($text,$chars = []) {

        $currentText = $text;

        foreach($chars as $char) {

            $currentText = str_replace($char, '', $currentText);

        }

        return $currentText;
    }
}