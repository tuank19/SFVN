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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Define foreign key constraint for parent_id
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
