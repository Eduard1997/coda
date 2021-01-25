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
        \DB::statement("DELETE FROM menus WHERE id=49;");
        \DB::statement("DELETE FROM menus WHERE id=56;");
        \DB::statement("DELETE FROM menus WHERE id=14;");
        \DB::statement("DELETE FROM menus WHERE id=15;");
        \DB::statement("DELETE FROM menus WHERE id=16;");
        \DB::statement("DELETE FROM menus WHERE id=33;");
        \DB::statement("DELETE FROM menus WHERE id=34;");
        \DB::statement("DELETE FROM menus WHERE id=35;");
        \DB::statement("DELETE FROM menus WHERE id=37;");
        \DB::statement("DELETE FROM menus WHERE id=38;");
        \DB::statement("DELETE FROM menus WHERE id=39;");
        \DB::statement("DELETE FROM menus WHERE id=40;");
        \DB::statement("DELETE FROM menus WHERE id=43;");
        \DB::statement("DELETE FROM menus WHERE id=47;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=54;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=55;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=49;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=56;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=14;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=15;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=16;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=33;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=34;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=35;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=37;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=38;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=39;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=40;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=43;");
        \DB::statement("DELETE FROM menu_role WHERE menus_id=47;");
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
