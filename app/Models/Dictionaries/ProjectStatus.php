<?php

namespace App\Models\Dictionaries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//  ['Отправлен на проверку', 1],
//        ['Идет сбор', 2],
//        ['Сбор завершен', 3],
//        ['Сбор завершен, деньги переведены', 4],
//        ['Сбор отменен', 5],
//        ['Сбор отменен, деньги возвращены', 6],
class ProjectStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function get_public_statuses()
    {
        return ProjectStatus::whereNotIn('id', [1, 4, 5, 6])->get();
    }
}
