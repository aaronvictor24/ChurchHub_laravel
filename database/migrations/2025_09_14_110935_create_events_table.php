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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('church_id');
            $table->unsignedBigInteger('secretary_id');
            $table->timestamps();

            $table->foreign('church_id')
                ->references('church_id')
                ->on('tbl_churches')
                ->onDelete('cascade');

            $table->foreign('secretary_id')
                ->references('secretary_id')
                ->on('tbl_secretaries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
