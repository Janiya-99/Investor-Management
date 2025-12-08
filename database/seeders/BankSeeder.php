<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = resource_path('seeders/bank/banks.json');

        if (File::exists($jsonPath)) {
            $json = File::get($jsonPath);
            $banks = json_decode($json, true);

            foreach ($banks as $bank) {

                Bank::create([
                    'bank_code' => $bank['ID'],
                    'bank_name' => $bank['name']
                ]);
            }

            $this->command->info('BankSeeder: Seeding completed successfully.');
        } else {
            $this->command->error("The file does not exist at path: {$jsonPath}");
        }
    }
}
