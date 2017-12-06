<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ここから追記
        DB::table('todos')->truncate();

        DB::table('todos')->insert([
            [
                'title'      => 'フレームワークカリキュラムを終わらせる',
                'created_at' => '2018-01-01 23:59:59',
                'updated_at' => '2018-01-04 23:59:59',
            ],
            [
                'title'      => 'Unixオペレーションに慣れる',
                'created_at' => '2018-02-01 00:00:00',
                'updated_at' => '2018-02-05 00:00:00',
            ],
        ]);
        // ここまで追記
    }
}
