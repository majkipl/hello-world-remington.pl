<?php

use App\Enums\ShopType;
use App\Enums\Voivodeship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id()->startingValue(202300000);
            $table->string('firstname', 128);
            $table->string('lastname', 128);
            $table->string('address', 128);
            $table->string('city', 128);
            $table->string('zip', 6);
            $table->enum('voivodeship', Voivodeship::ALL);
            $table->string('phone', 32);
            $table->string('email', 320)->unique();
            $table->enum('shop_type', ShopType::TYPES);
            $table->date('buyday');
            $table->string('number_receipt', 128);
            $table->string('img_receipt', 255);
            $table->string('img_ean', 255);

            $table->boolean('legal_1')->default(true);
            $table->boolean('legal_2')->default(true);
            $table->boolean('legal_3')->default(true);
            $table->boolean('legal_4')->default(false);
            $table->boolean('legal_5')->default(false);

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('whence_id');
            $table->foreign('whence_id')->references('id')->on('whences')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });

//        DB::statement('ALTER TABLE applications AUTO_INCREMENT = 202300000');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
