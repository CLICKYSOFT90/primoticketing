<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('event_tickets')) {
            Schema::create('event_tickets', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('organization_id')->nullable();
                $table->bigInteger('parent_event_id')->nullable();
                $table->integer('ticket_type_id')->nullable();
                $table->string('ticket_type_name')->nullable();
                $table->double('ticket_default_price',16,2)->nullable();
                $table->integer('ticket_default_limit')->nullable();
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
