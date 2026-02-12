<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            if (!Schema::hasColumn('expenses', 'purpose')) {
                $table->string('purpose')->nullable()->after('expense_date');
            }
            if (!Schema::hasColumn('expenses', 'requested_by')) {
                $table->string('requested_by')->nullable()->after('purpose');
            }
            if (!Schema::hasColumn('expenses', 'released_to')) {
                $table->string('released_to')->nullable()->after('requested_by');
            }
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            if (Schema::hasColumn('expenses', 'released_to')) {
                $table->dropColumn('released_to');
            }
            if (Schema::hasColumn('expenses', 'requested_by')) {
                $table->dropColumn('requested_by');
            }
            if (Schema::hasColumn('expenses', 'purpose')) {
                $table->dropColumn('purpose');
            }
        });
    }
};
