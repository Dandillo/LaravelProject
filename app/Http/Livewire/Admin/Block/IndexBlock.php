<?php

namespace App\Http\Livewire\Admin\Block;

use App\Models\Block;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class IndexBlock extends Component
{
    public function render()
    {
        $blocks = Block::paginate(Config::get('paginate_count'));
        return view('livewire.admin.block.index-block', compact('blocks'))->extends('layouts.admin');
    }
}
