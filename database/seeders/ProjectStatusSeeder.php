<?php

namespace Database\Seeders;

use App\Models\Dictionaries\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    public $blocks = array(
        ['Отправлен на проверку', 1],
        ['Идет сбор', 2],
        ['Сбор завершен', 3],
        ['Сбор завершен, деньги переведены', 4],
        ['Сбор отменен', 5],
        ['Сбор отменен, деньги возвращены', 6],
    );

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->blocks as $item) {
            ProjectStatus::create([
                'name' => $item[0],
                'id' => $item[1],
            ]);
        }
    }
}
