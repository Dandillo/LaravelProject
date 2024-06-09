<?php

namespace App\Http\Livewire\Admin\Dictionaries;

use App\Traits\DictionariesFinder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class DictForm extends Component
{
    use DictionariesFinder;

    public $item_id, $model;

    public $is_update = false;
    public $name = '';
    public $model_name = '';
    public $search = '';

    public $rules = [
        'name' => ['required', 'max:250'],
    ];

    public function mount()
    {
        if (!isset($this->model)) {
            $route_name = Route::currentRouteName();
            $result = $this->find_dict_type($route_name);
            $this->model_name = $result['name'];
            $this->model = $result['model'];
        }
    }

    public function render()
    {
        return view('livewire.admin.dictionaries.dict-form', [
            'items' => $this->model::where('name', 'like', '%' . $this->search . '%')->paginate(Config::get('paginate_count')),
        ])->extends('layouts.admin');
    }

    public function store()
    {
        $this->validate();

        $this->model::create(['name' => $this->name]);
        $this->clearForm();
    }


    public function edit($id)
    {
        $this->is_update = true;
        $this->item_id = $id;
        $dict_item = $this->model::find($id);
        $this->name = $dict_item->name;
    }

    public function update()
    {
        $this->validate();

        if (isset($this->item_id)) {
            $dict_item = $this->model::find($this->item_id);
            $dict_item->update([
                'name' => $this->name,
            ]);

            $this->item_id = null;
            $this->is_update = false;
            $this->clearForm();
        }
    }

    public function delete($id)
    {
        if (isset($id)) {
            $dict_item = $this->model::find($id)->delete();
        }
    }

    public function clearForm()
    {
        $this->name = '';
    }
}
