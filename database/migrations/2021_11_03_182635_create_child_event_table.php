<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('event_child')) {
            Schema::create('event_child', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('organization_id')->nullable();
                $table->bigInteger('parent_event_id')->nullable();
                $table->string('name')->nullable();
                $table->dateTime('event_start')->nullable();
                $table->dateTime('event_end')->nullable();
                $table->string('event_icon')->nullable();
                $table->text('address')->nullable();
                $table->boolean('active')->default(1);
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
