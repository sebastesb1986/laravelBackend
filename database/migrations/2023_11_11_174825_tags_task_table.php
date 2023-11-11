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
        Schema::create('tags_task', function (Blueprint $table) {
            
            $table->id();
             // Relationship with tags and tasks 
             $table->bigInteger('tags_id')->unsigned();
             $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');

             $table->bigInteger('task_id')->unsigned();
             $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags_task');
    }
};
