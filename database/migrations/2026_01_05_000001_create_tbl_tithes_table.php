<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tbl_tithes', function (Blueprint $table) {
            $table->bigIncrements('tithe_id');
            $table->unsignedBigInteger('church_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('mass_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('encoder_id')->nullable();
            $table->timestamps();

            $table->foreign('church_id')
                ->references('church_id')
                ->on('tbl_churches')
                ->onDelete('cascade');
            $table->foreign('member_id')
                ->references('member_id')
                ->on('members')
                ->onDelete('set null');
            $table->foreign('mass_id')
                ->references('mass_id')
                ->on('tbl_masses')
                ->onDelete('set null');
            $table->foreign('encoder_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::dropIfExists('tbl_tithes');
    }
};
