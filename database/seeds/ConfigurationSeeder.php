<?php

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        foreach ($data as $config) {
            if(empty(Configuration::where('module', $config['module'])->where('key', $config['key'])->get()->first())){
                DB::table('configurations')->updateOrInsert([
                    'module' => $config['module'],
                    'key' => $config['key'],
                    'description' => $config['description'],
                    'value' => $config['value'],
                    'forAdmin' => empty($config['forAdmin']) ? 0 : $config['forAdmin'],
                ]);
            }
        }
    }
}
