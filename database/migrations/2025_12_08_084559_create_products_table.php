<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('period_type');
            $table->integer('period');
            $table->float('min_interest_rate');
            $table->float('max_interest_rate');
            $table->float('min_amount');
            $table->float('max_amount');
            $table->string('interest_calculation_type');
            $table->integer('capital_withdrawal_notice_period');
            $table->string('penalty_type')->nullable();
            $table->float('penalty_min_rate')->nullable();
            $table->float('penalty_max_rate')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('last_updated_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
