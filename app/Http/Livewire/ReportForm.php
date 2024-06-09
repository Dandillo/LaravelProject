<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReportForm extends Component
{
    public $report_text, $email, $project_id, $project_title;

    protected $rules = [
        'report_text' => ['required', 'max:2000'],
        'email' => ['required', 'max:150', 'email'],
    ];

    public function mount()
    {
        if (Auth::check()) {
            $this->email = Auth::user()->email;
        }
        $this->project_id = $_GET['project'] ?? null;
        $this->project_title = Project::find($this->project_id)->title ?? '';
    }

    public function send()
    {
        $this->validate();

        Report::create([
            'email' => $this->email,
            'report_text' => $this->report_text,
            'project_id' => $this->project_id,
            'is_checked'=> false
        ]);


        session()->flash('scs_msg', 'Ваша жалоба отправлена. Модераторы свяжутся с вами, если это будет необходимо');

    }

    public function render()
    {
        return view('livewire.report-form')->extends('layouts.app');
    }
}
