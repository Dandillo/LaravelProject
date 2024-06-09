<?php

namespace App\Http\Livewire\Admin\Page;

use App\Models\InfoPage;
use Livewire\Component;

class PageForm extends Component
{
    public $is_update = false, $page_item;
    public $title, $link, $description, $is_public = false;

    public $rules = [
        'title' => ['required', 'max:100'],
        'link' => ['required', 'max:50'],
        'description' => ['required', 'max:4000'],
    ];

    public function mount($page = null)
    {
        if (isset($page)) {
            $page = InfoPage::find($page);
            $this->page_item = $page;
            $this->is_update = true;
            $this->title = $page->title;
            $this->link = $page->link;
            $this->description = $page->text;
            $this->is_public = $page->is_public;
        }
    }

    public function store()
    {
        $this->validate();

        InfoPage::create([
            'title' => $this->title,
            'link' => $this->link,
            'text' => $this->description,
            'is_public' => $this->is_public,
        ]);

        return redirect()->intended(route('admin.pages'));
    }

    public function update()
    {
        $this->validate();

        $this->page_item->update([
            'title' => $this->title,
            'link' => $this->link,
            'text' => $this->description,
            'is_public' => $this->is_public,
        ]);

        $this->page_item->save();
        $this->is_update = false;
        $this->page_item = null;

        return redirect()->intended(route('admin.pages'));
    }

    public function render()
    {
        return view('livewire.admin.page.page-form')->extends('layouts.admin');
    }
}
