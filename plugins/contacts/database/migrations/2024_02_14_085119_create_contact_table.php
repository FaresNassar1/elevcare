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
        Schema::create(
            'contactus',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 255)->nullable()->default(null);
                $table->string('email', 255)->nullable()->default(null);
                $table->string('subject', 255)->nullable()->default(null);
                $table->string('message', 255)->nullable()->default(null);
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('contactus');
    }
};
