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
        Schema::create('mass_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mass_id');
            $table->unsignedBigInteger('member_id');
            $table->boolean('attended')->default(false);
            $table->timestamps();

            $table->unique(['mass_id', 'member_id']);

            $table->foreign('mass_id')
                ->references('mass_id')
                ->on('tbl_masses')
                ->onDelete('cascade');

            $table->foreign('member_id')
                ->references('member_id')
                ->on('members')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mass_attendances');
    }
};
