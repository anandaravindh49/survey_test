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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('package_name')->nullable();
            $table->string('machine_state')->nullable();
            $table->string('business_area')->nullable();
            $table->string('machine_district')->nullable();
            $table->string('machine_block')->nullable();
            $table->string('make')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('operator_id')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('code')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
