<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("DELETE FROM menus WHERE id=54;");
        \DB::statement("DELETE FROM menus WHERE id=55;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=54;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=55;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
