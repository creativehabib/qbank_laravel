<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign key from past_exams before renaming
        Schema::table('past_exams', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
        });

        // Rename the main table
        Schema::rename('institutions', 'organizations');

        // Rename columns and re-add foreign key
        Schema::table('past_exams', function (Blueprint $table) {
            $table->renameColumn('institution_id', 'organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        // Rename columns in users table
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'institution_name')) {
                $table->renameColumn('institution_name', 'organization_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'organization_name')) {
                $table->renameColumn('organization_name', 'institution_name');
            }
        });

        Schema::table('past_exams', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->renameColumn('organization_id', 'institution_id');
        });

        Schema::rename('organizations', 'institutions');

        Schema::table('past_exams', function (Blueprint $table) {
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
        });
    }
};
