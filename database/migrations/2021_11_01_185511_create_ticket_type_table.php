<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ticket_types')) {
            Schema::create('ticket_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('organization_id')->nullable();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->bigInteger('event_type_id')->nullable();
                $table->double('default_price',16,2)->nullable();
                $table->integer('default_limit')->nullable();
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
