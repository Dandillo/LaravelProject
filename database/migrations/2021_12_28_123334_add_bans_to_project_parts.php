<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBansToProjectParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_news', function (Blueprint $table) {
            $table->boolean('is_banned')->nullable();
            $table->date('ban_date')->nullable();
            $table->foreignId('banned_admin')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('is_banned')->nullable();
            $table->date('ban_date')->nullable();
            $table->foreignId('banned_admin')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->boolean('is_banned')->nullable();
            $table->date('ban_date')->nullable();
            $table->foreignId('banned_admin')->nullable()->constrained('users')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_news', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'ban_date', 'banned_admin']);
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'ban_date', 'banned_admin']);
        });
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'ban_date', 'banned_admin']);
        });
    }
}
