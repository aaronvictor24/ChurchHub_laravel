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
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->unsignedBigInteger('church_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('contact_number', 11)->unique()->nullable();
            $table->date('birth_date');
            $table->integer('age');
            $table->string('gender', 10);
            $table->string('address');
            $table->timestamps();

            $table->foreign('church_id')
                ->references('church_id')
                ->on('tbl_churches')
                ->onDelete('cascade'); // 🔗 Cascade on delete
        });
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedBigInteger('secretary_id')->after('church_id');

            $table->foreign('secretary_id')
                ->references('id')
                ->on('users')   // assuming secretaries are in the `users` table
                ->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['secretary_id']);
            $table->dropColumn('secretary_id');
        });
    }
};
