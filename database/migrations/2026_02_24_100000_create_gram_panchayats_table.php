<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gram_panchayats', function (Blueprint $table) {
            $table->id();
            $table->string('state_name')->nullable();
            $table->string('business_area')->nullable();
            $table->string('district_name')->nullable();
            $table->string('block_name')->nullable();
            $table->string('gp_name')->nullable();
            $table->string('gp_code')->nullable();
            $table->string('gp_type')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gram_panchayats');
    }
};
