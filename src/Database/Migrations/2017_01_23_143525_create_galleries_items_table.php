<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGalleriesItemsTable
 */
class CreateGalleriesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('gallery_id');
            $table->string('path');
            $table->unsignedTinyInteger('weight');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
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
        Schema::drop('galleries_items');
    }
}
