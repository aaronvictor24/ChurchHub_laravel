<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tbl_tithes', function (Blueprint $table) {
            $table->boolean('is_pledge')->default(false)->after('member_id');
            $table->string('pledger_name')->nullable()->after('is_pledge');
        });
    }

    public function down()
    {
        Schema::table('tbl_tithes', function (Blueprint $table) {
            $table->dropColumn(['is_pledge', 'pledger_name']);
        });
    }
};
