<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message', function(Blueprint $table){

          $table->foreign('user_id', 'user')
                ->reference('id')
                ->on('users')
                ->onDelete('cascade');
          $table->foreign('rental_id', 'rental')
                ->reference('id')
                ->on('rentals')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table){

          $table->dropForeign('user');
          $table->dropForeign('rental');
        })
    }
}
