<?php

namespace Corals\Modules\Medical\database\seeds;

use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Models\Village;
use Corals\Modules\Medical\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MedicalDataDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedCities();
        $this->seedVillages();
        $this->seedPatients();
    }

    private function seedCities()
    {
        $cities = [
            "سلفيت",
            "رام الله",
            "نابلس",
            "الخليل",
            "بيت لحم",
            "أريحا",
            "جنين",
            "طولكرم",
            "قلقيلية",
            "طوباس"
        ];

        foreach ($cities as $city) {
            City::updateOrCreate([
                'name' => $city
            ]);
        }
    }

    private function seedVillages()
    {
        $villages = [
            ['name' => 'سلفيت', 'city_id' => 1],
            ['name' => 'بديا', 'city_id' => 1]
        ];

        foreach ($villages as $village) {
            Village::updateOrCreate(
                ['name' => $village['name'], 'city_id' => $village['city_id']],
                $village
            );
        }
    }

    private function seedPatients()
    {
        $csvFile = fopen(base_path("Corals/modules/Medical/database/data/smallPatientProfiles.csv"), "r");

        if (!$csvFile) {
            return;
        }

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $date_of_birth = Carbon::createFromFormat('m/d/Y', $data[2])->format('Y-m-d');

                $gender = $data[8] == 1 ? 'male' : 'female';

                $marital_status = $data[7] == 1 ? 'single' : 'married';

                Patient::create([
                    "name" => $data[0],
                    "id_number" => $data[1],
                    "date_of_birth" => $date_of_birth,
                    "age_in_years" => $data[3],
                    "age_in_months" => $data[4],
                    "city_id" => $data[5],
                    "village_id" => $data[6],
                    "marital_status" => $marital_status,
                    "gender" => $gender,
                    "phone" => $data[9]
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}