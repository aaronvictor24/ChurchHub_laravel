<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('church_id');
            $table->decimal('amount', 12, 2);
            $table->string('description')->nullable();
            $table->date('expense_date');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('church_id')->references('church_id')->on('tbl_churches')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
