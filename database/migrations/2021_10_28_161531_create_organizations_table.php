<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('organizations')) {
            Schema::create('organizations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('agent_name')->nullable();
                $table->string('agent_phone_number')->nullable();
                $table->string('organization_contact_name')->nullable();
                $table->string('organization_contact_phone_number')->nullable();
                $table->string('email')->nullable();
                $table->string('organization_name')->nullable();
                $table->string('organization_icon')->nullable();
                $table->string('organization_website')->nullable();
                $table->string('organization_unique_url')->nullable();
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
