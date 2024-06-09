<?php

namespace App\Traits;

use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectStatus;
use App\Models\Dictionaries\ProjectTag;
use App\Models\Dictionaries\Region;

trait DictionariesFinder
{
//  Поиск модели по названию пути route
    public function find_dict_type($type)
    {
        switch ($type) {
            case 'admin.region':
                return ['model' => Region::class, 'name' => 'Регионы'];
            case 'admin.tag':
                return ['model' => ProjectTag::class, 'name' => 'Тэги проекта'];
            case 'admin.theme':
                return ['model' => ProjectCategory::class, 'name' => 'Тема проекта'];
            case 'admin.status':
                return ['model' => ProjectStatus::class, 'name' => 'Статус проекта'];
            default:
                abort(404);
        }
    }
}
