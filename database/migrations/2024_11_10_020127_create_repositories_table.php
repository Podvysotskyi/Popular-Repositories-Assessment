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
        Schema::create('github_repositories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('owner_id')->references('id')->on('github_repository_owners');
            $table->integer('import_id')->unique();
            $table->string('name');
            $table->string('url');
            $table->text('description')->nullable();
            $table->integer('stars_count');
            $table->timestamp('repository_created_at');
            $table->timestamp('repository_pushed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_repositories');
    }
};
