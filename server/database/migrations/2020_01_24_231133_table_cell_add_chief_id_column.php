<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableCellAddChiefIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("cells", function (Blueprint $table) {
            $table->bigInteger("chief_id")
                ->nullable()
                ->unsigned();

            $table->foreign("chief_id")
                ->references("id")
                ->on("cells")
                ->onDelete("set null");
        });
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
