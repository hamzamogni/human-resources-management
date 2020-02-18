<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdCellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("cells", function (Blueprint $table) {
            $table->bigInteger("parent_id")
                ->nullable()
                ->unsigned();

            $table->foreign("parent_id")
                ->references("id")
                ->on("cells");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table("cells", function (Blueprint $table) {
//            $table->dropColumn("parent_id");
//        });
    }
}
