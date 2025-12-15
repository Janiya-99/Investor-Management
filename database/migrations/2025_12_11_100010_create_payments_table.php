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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investment_id')->constrained('investments');
            $table->foreignId('investor_bank_details_id')->nullable()->constrained('investor_has_bank_details');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->date('payment_date');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['capital', 'interest', 'penalty', 'other'])->default('interest');
            $table->enum('status', ['pending', 'posted', 'void'])->default('posted');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
