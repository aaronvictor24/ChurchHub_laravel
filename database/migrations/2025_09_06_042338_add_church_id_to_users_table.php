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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('church_id')->nullable()->after('role_id');

            // fix foreign key reference
            $table->foreign('church_id')
                ->references('church_id')
                ->on('tbl_churches')   // ✅ correct table name
                ->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropColumn('church_id');
        });
    }
};
