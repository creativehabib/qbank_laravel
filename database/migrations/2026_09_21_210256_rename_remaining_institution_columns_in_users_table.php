<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'institution_address')) {
                $table->renameColumn('institution_address', 'organization_address');
            }
            if (Schema::hasColumn('users', 'institution_type')) {
                $table->renameColumn('institution_type', 'organization_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'organization_address')) {
                $table->renameColumn('organization_address', 'institution_address');
            }
            if (Schema::hasColumn('users', 'organization_type')) {
                $table->renameColumn('organization_type', 'institution_type');
            }
        });
    }
};
