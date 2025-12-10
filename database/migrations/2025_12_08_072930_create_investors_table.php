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
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('nic')->nullable();
            $table->string('contact_no')->nullable();
            $table->longText('address_line_1')->nullable();
            $table->longText('address_line_2')->nullable();
            $table->longText('address_line_3')->nullable();
            $table->string('beneficiary_full_name')->nullable();
            $table->string('beneficiary_nic')->nullable();
            $table->string('beneficiary_contact_no')->nullable();
            $table->string('beneficiary_relation')->nullable();
            $table->date('registration_date')->nullable();
            $table->timestamp('last_updated_date_time');
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('tax_status', ['payable', 'non_payable'])->default('non_payable');
            $table->string('tax_no')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('last_updated_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};
