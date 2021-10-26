<?php

use Illuminate\Database\Seeder;
class FlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        foreach ($data as $flag){
            if(empty(App\Models\Flag::where('flagType', $flag['flagType'])->where('name', $flag['name'])->get()->first())){
                DB::table('flags')->updateOrInsert([
                    'flagType' => $flag['flagType'],
                    'name' => $flag['name'],
                    'field1' => !empty($flag['field1']) ? $flag['field1'] : null,
                    'field2' => !empty($flag['field2']) ? $flag['field2'] : null
                ]);
            }
        }
    }
}
