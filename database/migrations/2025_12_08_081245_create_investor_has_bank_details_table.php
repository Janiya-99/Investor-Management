<?php

use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Investor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('investor_has_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Investor::class)->constrained('investors');
            $table->foreignIdFor(BankBranch::class)->constrained('bank_branches');
            $table->foreignIdFor(Bank::class)->constrained('banks');
            $table->string('account_number');
            $table->string('account_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_has_bank_details');
    }
};
