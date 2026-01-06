<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMassOfferingsTable extends Migration
{
    public function up()
    {
        Schema::create('mass_offerings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mass_id');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('encoded_by'); // secretary or admin ID
            $table->timestamps();

            $table->foreign('mass_id')
                ->references('mass_id')
                ->on('tbl_masses')
                ->onDelete('cascade');

            $table->foreign('encoded_by')
                ->references('id')
                ->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mass_offerings');
    }
}
