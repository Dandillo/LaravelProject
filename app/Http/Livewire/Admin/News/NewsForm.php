<?php

namespace App\Http\Livewire\Admin\News;

use App\Models\News;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewsForm extends Component
{
    use WithFileUploads, FileUploader;

    public $news_item, $is_update = false;
    public $title, $description, $image_card, $image_header, $is_public = false;

    protected $rules = [
        'title' => ['required', 'max:150'],
        'description' => ['required', 'max:4000'],
        'image_card' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:4096'],
        'image_header' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:4096'],
    ];

    public function mount($news = null)
    {
        if (isset($news)) {
            $news = News::find($news);
            $this->news_item = $news;
            $this->title = $news->title;
            $this->description = $news->description;
            $this->is_public = $news->is_public;
            $this->is_update = true;
        }
    }

    public function store()
    {
        $this->validate();

        if ($this->image_card) {
            $card_path = $this->upload_image($this->image_card, null, 'news');
        }
        if ($this->image_header) {
            $header_path = $this->upload_image($this->image_header, null, 'news');
        }

        $news = News::create([
            'title' => $this->title,
            'description' => $this->description,
            'is_public' => $this->is_public ?? false,
            'image_card' => $card_path ?? null,
            'image_header' => $header_path ?? null,
        ]);

        $news->save();

        return redirect()->intended(route('admin.news'));
    }


    public function update()
    {
        $this->validate();

        if (isset($this->news_item)) {
            $this->news_item->update([
                'title' => $this->title,
                'description' => $this->description,
                'is_public' => $this->is_public ?? false,
            ]);
            if (isset($this->image_card) && $this->image_card != '') {
                //Сохранение нового изображения
                $card_path = $this->upload_image($this->image_card, $this->news_item, 'news');
                //Запись пути к новому файлу
                $this->news_item->image_card = $card_path;
            }
            if (isset($this->image_header) && $this->image_header != '') {
                $header_path = $this->upload_image($this->image_header, $this->news_item, 'news');
                //Запись пути к новому файлу
                $this->news_item->image_header = $header_path;
            }

            $this->news_item->save();
            $this->news_item = null;
            $this->is_update = false;
        }
        return redirect()->intended(route('admin.news'));
    }

    public function render()
    {
        return view('livewire.admin.news.news-form')->extends('layouts.admin');
    }
}
