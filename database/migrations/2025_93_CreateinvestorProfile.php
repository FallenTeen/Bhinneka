<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('investor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('address')->nullable();
            $table->text('description');
            $table->string('investment_range');
            $table->string('website')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('status', ['active', 'pending', 'suspended'])->default('pending');
            $table->boolean('verified')->default(false);
            $table->json('investment_interest')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investor_profiles');
    }
};