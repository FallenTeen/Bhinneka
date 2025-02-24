<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('investor_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_profile_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('position');
            $table->string('location');
            $table->string('employment_type'); 
            $table->json('required_skills');
            $table->decimal('salary_range_start', 12, 2)->nullable();
            $table->decimal('salary_range_end', 12, 2)->nullable();
            $table->date('deadline')->nullable();
            $table->string('contact_email');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investor_posts');
    }
};