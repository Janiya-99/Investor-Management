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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('investor_id')->constrained('investors');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('investor_bank_details_id')->nullable()->constrained('investor_has_bank_details');

            $table->decimal('investment_amount', 15, 2);
            $table->decimal('interest_rate', 8, 4);
            $table->string('interest_calculation_type')->nullable(); // Interest_Cal_Type (simple/compound)

            $table->string('period_type');           
            $table->unsignedInteger('period');      

            $table->date('start_date');
            $table->date('maturity_date')->nullable();
            $table->string('received_date_time', 45)->nullable(); 
            $table->string('created_date_time', 45)->nullable(); 

            $table->decimal('capital_balance', 15, 2)->default(0);
            $table->decimal('interest_balance', 15, 2)->default(0);
            $table->decimal('total_balance', 15, 2)->default(0);

            $table->unsignedInteger('capital_withdrawal_notice_period')->default(0);
            $table->string('notice_period', 45)->nullable();  
            $table->string('penalty_type')->nullable();      
            $table->decimal('penalty_min_rate', 8, 4)->nullable(); 
            $table->decimal('penalty_max_rate', 8, 4)->nullable(); 

            $table->enum('status', ['draft', 'active', 'closed', 'cancelled'])->default('active');
            $table->text('notes')->nullable();

//            $table->foreignId('interest_schedule_id')->nullable()->constrained('interest_schedules');

            $table->string('approved_date_time', 45)->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('last_updated_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
