<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('area_id');
            $table->boolean('is_negotiable')->default(false);
            $table->string('amount')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn([
                'condition_id',
                'amount',
                'unit_id',
                'is_negotiable',
                'area_id'
            ]);
        });
    }
}
