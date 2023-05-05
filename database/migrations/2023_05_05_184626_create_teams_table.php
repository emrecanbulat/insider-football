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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('strength')->default(10);
            $table->smallInteger('points')->default(0);
            $table->smallInteger('played')->default(0);
            $table->smallInteger('win')->default(0);
            $table->smallInteger('drawn')->default(0);
            $table->smallInteger('lost')->default(0);
            $table->smallInteger('goal_dif')->default(0);
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
