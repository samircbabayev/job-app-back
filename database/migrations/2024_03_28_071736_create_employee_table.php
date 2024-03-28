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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');

            $table->string('employee_id',255)->unique();

            $table->string('username',255)->nullable();
            $table->string('name_prefix',255)->nullable();
            $table->string('first_name',255)->nullable();
            $table->string('middle_initial',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('gender',255)->nullable();
            $table->string('email',255)->nullable();
            $table->datetime('birth_date')->nullable();
            $table->time('birth_time')->nullable();
            $table->string('date_of_birth',255)->nullable();
            $table->string('time_of_birth',255)->nullable();
            $table->string('age_in_years',255)->nullable();
            $table->timestamp('join_time')->nullable();
            $table->string('date_of_joining')->nullable();
            $table->string('age_in_company_years',255)->nullable();
            $table->string('phone',255)->nullable();
            $table->string('place_name',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('city',255)->nullable();
            $table->string('zip',255)->nullable();
            $table->string('region',255)->nullable();

            // $table->time('time_of_birth')->nullable();
            // $table->decimal('age_in_years', 8, 2);
            // $table->date('date_of_joining');
            // $table->decimal('age_in_company_years', 8, 2);

            $table->softDeletes()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
