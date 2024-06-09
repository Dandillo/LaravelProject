<?php

namespace App\Http\Livewire\Admin\Page;

use App\Models\InfoPage;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class IndexPage extends Component
{
    public $search = '';

    public function delete($id)
    {
        if (isset($id)) {
            $page = InfoPage::find($id)->delete();
        }
    }
    public function render()
    {
        return view('livewire.admin.page.index-page',
            ['pages' => InfoPage::where('title', 'like', '%' . $this->search . '%')
                ->paginate(Config::get('paginate_count'))])->extends('layouts.admin');
    }
}
