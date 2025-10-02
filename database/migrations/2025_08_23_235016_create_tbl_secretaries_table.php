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
        Schema::create('tbl_secretaries', function (Blueprint $table) {
            $table->id('secretary_id');
            $table->unsignedBigInteger('church_id');
            $table->string('first_name', 55);
            $table->string('middle_name', 55)->nullable();
            $table->string('last_name', 55);
            $table->string('suffix_name', 55)->nullable();
            $table->integer('age');
            $table->date('birth_date');
            $table->string('gender', 10);
            $table->string('address', 255);
            $table->string('contact_number', 55);
            $table->string('email', 55)->unique();
            $table->string('password', 255);
            $table->tinyInteger('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('church_id')
                ->references('church_id')
                ->on('tbl_churches')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_secretaries');
    }
};
