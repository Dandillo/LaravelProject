<?php

namespace App\Http\Livewire\Admin\Block;

use App\Models\Block;
use App\Models\BlockProject;
use App\Models\Project;
use Livewire\Component;

class BlockForm extends Component
{
    public $block, $pinned_projects, $weight, $projects;

    public function mount(?Block $block)
    {
        $this->block = $block;
        $this->pinned_projects = $block->projects()->pluck('project_id')->toArray();
        $this->weight = $block->projects()->pluck('weight')->toArray();
        $this->projects = Project::where('status_id', 2)->get(['id', 'title']);

    }

    public function save()
    {
//        Удаляем старые
        BlockProject::where('block_id', $this->block->id)->delete();

//        Каждый новый сохраняем
        foreach ($this->pinned_projects as $k => $pinned) {
            BlockProject::create([
                'block_id' => $this->block->id,
                'project_id' => $pinned,
                'weight' => $this->weight[$k] ?? null,
            ]);
        }

        return redirect()->intended(route('admin.blocks'));
    }

    public function render()
    {
        $block_projects = $this->block->projects();
        return view('livewire.admin.block.block-form', compact(['block_projects']))->extends('layouts.admin');
    }
}
