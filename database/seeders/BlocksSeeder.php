<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlocksSeeder extends Seeder
{
    public $blocks = array(
        ['Популярные проекты', 'popular_projects', 3],
        ['Рекомендуемые проекты', 'relevant_projects', 3],
        ['Карусель на главной', 'main_carousel', 6],
        ['Карусель на странице проектов', 'projects_carousel', 6],
    );

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('blocks')->truncate();
        foreach ($this->blocks as $item) {
            Block::create([
               'name' => $item[0],
               'type'=> $item[1],
                'count' => $item[2],
            ]);
        }
    }
}
