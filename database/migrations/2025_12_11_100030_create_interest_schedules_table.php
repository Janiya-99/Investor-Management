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
        Schema::create('interest_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investment_id')->constrained()->cascadeOnDelete();
            $table->date('due_date');
            $table->decimal('interest_amount', 15, 2);
            $table->decimal('capital_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->date('paid_at')->nullable();
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->string('status')->default('pending'); // pending, scheduled, paid, overdue, cancelled
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_schedules');
    }
};

