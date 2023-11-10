<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up()
{
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });

    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('role_id')->nullable();
        $table->foreign('role_id')->references('id')->on('roles');
    });
    Artisan::call('db:seed', [
        '--class' => 'RoleSeeder',
        '--force' => true
     ]);
   
}
public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['role_id']);
        $table->dropColumn('role_id');
    });
    Schema::dropIfExists('roles');
}

    /**
     * Run the migrations.
     *//*
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
*/
    /**
     * Reverse the migrations.
     *//*
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }*/
};
