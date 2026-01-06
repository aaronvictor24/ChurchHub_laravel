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
        Schema::create('tbl_masses', function (Blueprint $table) {
            $table->id('mass_id');
            $table->unsignedBigInteger('church_id');
            $table->string('mass_title')->nullable(); // e.g. Sunday Mass, Funeral Mass
            $table->string('mass_type')->default('regular'); // regular or special
            $table->date('mass_date'); // for special mass, or start of recurring
            $table->time('start_time');
            $table->time('end_time');
            $table->string('day_of_week')->nullable(); // for regular weekly mass (e.g. Sunday)
            $table->boolean('is_recurring')->default(false);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('tbl_masses');
    }
};
