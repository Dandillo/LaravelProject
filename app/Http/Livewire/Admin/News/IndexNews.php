<?php

namespace App\Http\Livewire\Admin\News;

use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class IndexNews extends Component
{
    use WithPagination;

    public $search = '';
    protected $queryString = ['search'];


    public function delete($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(404);
        }
        if (isset($id)) {
            $news = News::find($id);
            if ($news) {
                Storage::delete('public/' . $news->image_header);
                Storage::delete('public/' . $news->image_card);
                $news->delete();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.news.index-news', [
            'news' => News::where('title', 'like', '%' . $this->search . '%')->paginate(Config::get('paginate_count'))
        ])->extends('layouts.admin');
    }
}
