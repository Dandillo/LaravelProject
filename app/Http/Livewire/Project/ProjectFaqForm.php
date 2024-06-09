<?php

namespace App\Http\Livewire\Project;

use App\Models\Faq;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectFaqForm extends Component
{
    public $project;
    public $faq_answer;

    protected $rules = [
        'faq_answer' => ['required', 'max:1000'],
    ];


    public function store($faq_id)
    {
        if ($this->project->user_id != Auth::id()) {
            abort(404);
        }

        $faq = Faq::find($faq_id);
        if (!isset($faq)) {
            abort(404);
        }

        $this->validate();

        $faq->update([
            'is_public' => true,
            'answer' => $this->faq_answer,
        ]);

        session()->flash('faq_ans_msg', 'Ответ опубликован');

        return $this->redirect(route('project.faqs', ['project' => $this->project->id]));
    }

    public function mount(Project $project)
    {
        $this->project = $project;
        if ($project->user_id != Auth::id()) {
            abort(404);
        }
    }

    public function render()
    {
        $project_faq = $this->project->public_faqs;
        $faqs_to_moderate = $this->project->new_faqs();
        $faqs_to_moderate = $faqs_to_moderate->orderByDesc('created_at')->paginate(12);

        return view('livewire.project.project-faq-form', ['project_faq' => $project_faq, 'faqs_to_moderate' => $faqs_to_moderate]);
    }
}
