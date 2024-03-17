<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'form_submissions',
            function (Blueprint $table) {
                $table->json('meta_data')->default(null)->nullable();

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
            'form_submissions',
            function (Blueprint $table) {
                $table->dropColumn('meta_data');
            }
        );
    }
};
