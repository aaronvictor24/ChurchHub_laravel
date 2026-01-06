<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_churches', function (Blueprint $table) {
            $table->id('church_id');
            $table->string('name', 150);
            $table->string('address', 255);
            $table->unsignedBigInteger('pastor_id')->nullable();
            $table->timestamps();

            $table->foreign('pastor_id')
                ->references('id')
                ->on('tbl_pastors')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_churches');
    }
};
