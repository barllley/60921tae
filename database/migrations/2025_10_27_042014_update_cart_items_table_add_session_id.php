<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('session_id', 100)->nullable()->after('user_id');

            $table->dropUnique(['user_id', 'ticket_id']);

            $table->unique(['user_id', 'ticket_id']);
            $table->unique(['session_id', 'ticket_id']);
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'ticket_id']);
            $table->dropUnique(['session_id', 'ticket_id']);

            $table->dropColumn('session_id');
            $table->foreignId('user_id')->nullable(false)->change();

            $table->unique(['user_id', 'ticket_id']);
        });
    }
};
