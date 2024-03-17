<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'forms',
            function (Blueprint $table) {
                $table->json('validations')->default(null)->after('form_definition');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'forms',
            function (Blueprint $table) {
                $table->dropColumn('validations');
            }
        );
    }
};
