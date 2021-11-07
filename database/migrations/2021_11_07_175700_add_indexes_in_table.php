<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('event_parent', 'organization_id')) {
            Schema::table('event_parent', function (Blueprint $table) {
                $indexes = collect(\DB::select("SHOW INDEXES FROM event_parent"))->pluck('Column_name')->toArray();
                if(!in_array("organization_id", $indexes)){
                    $table->index('organization_id');
                }
            });
        }
        if (Schema::hasColumn('event_child', 'organization_id')) {
            Schema::table('event_child', function (Blueprint $table) {
                $indexes = collect(\DB::select("SHOW INDEXES FROM event_child"))->pluck('Column_name')->toArray();
                if(!in_array("organization_id", $indexes)){
                    $table->index('organization_id');
                }
            });
        }
        if (Schema::hasColumn('event_tickets', 'organization_id')) {
            Schema::table('event_tickets', function (Blueprint $table) {
                $indexes = collect(\DB::select("SHOW INDEXES FROM event_tickets"))->pluck('Column_name')->toArray();
                if(!in_array("organization_id", $indexes)){
                    $table->index('organization_id');
                }
            });
        }
        if (Schema::hasColumn('event_types', 'organization_id')) {
            Schema::table('event_types', function (Blueprint $table) {
                $indexes = collect(\DB::select("SHOW INDEXES FROM event_types"))->pluck('Column_name')->toArray();
                if(!in_array("organization_id", $indexes)){
                    $table->index('organization_id');
                }
            });
        }
        if (Schema::hasColumn('ticket_types', 'organization_id')) {
            Schema::table('ticket_types', function (Blueprint $table) {
                $indexes = collect(\DB::select("SHOW INDEXES FROM ticket_types"))->pluck('Column_name')->toArray();
                if(!in_array("organization_id", $indexes)){
                    $table->index('organization_id');
                }
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
