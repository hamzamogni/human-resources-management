<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("cell_id")->nullable();
            $table->boolean("chief")->default(0);
            // $table->unsignedBigInteger("chief_of_cell")->nullable();
            $table->unsignedBigInteger("project_id")->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('address')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table("users", function (Blueprint $table)
        {
            $table->foreign("cell_id")
                    ->references("id")
                    ->on("cells")
                    ->onDelete("set null");

            // $table->foreign("chief_of_cell")
            //         ->references("id")
            //         ->on("cells")
            //         ->onDelete("SET NULL");
                    
            $table->foreign("project_id")
                    ->references("id")
                    ->on("projects")
                    ->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
