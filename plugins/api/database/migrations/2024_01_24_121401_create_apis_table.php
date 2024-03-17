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
        Schema::create(
            'awap_apis',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->string('version');
                $table->enum('method', ['post', 'get', 'delete', 'patch', 'put']);
                $table->json('headers');
                $table->text('origin_url');
                $table->text('edge_url');
                $table->json('params');
                $table->json('query');
                $table->json('body');
                $table->text('api_architecture')->nullable();
                $table->text('message');
                $table->longText('description');
                $table->boolean('status');
                $table->timestamps();
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
        Schema::dropIfExists('awap_apis');
    }
};
