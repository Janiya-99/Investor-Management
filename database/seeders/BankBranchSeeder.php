<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class BankBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $jsonPath = resource_path('seeders/branch/branches.json');

        if (File::exists($jsonPath)) {
            $json = File::get($jsonPath);
            $branches = json_decode($json, true);

            $totalCount = count($branches);
            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, $totalCount);
            $progressBar->start();
            
            foreach ($branches as $branch) {
                $bank=Bank::where('bank_code',$branch['bankID'])->first();
                BankBranch::create([
                    'bank_id' => $bank->id,
                    'bank_branch_code' => $branch['ID'],
                    'bank_branch_name' => $branch['name']
                ]);
                $progressBar->advance();
            }
            $progressBar->finish();
            $this->command->info('BankSeeder: Seeding completed successfully.');
        } else {
            $this->command->error("The file does not exist at path: {$jsonPath}");
        }
    }
}
