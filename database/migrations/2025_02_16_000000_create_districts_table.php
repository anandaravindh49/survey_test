<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('state_name');
            $table->string('business_area')->nullable();
            $table->string('district_name');
            $table->string('code')->unique();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('package_name');
            $table->index('state_name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
