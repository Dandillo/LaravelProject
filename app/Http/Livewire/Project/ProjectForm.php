<?php

namespace App\Http\Livewire\Project;

use App\Models\Award;
use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectStatus;
use App\Models\Dictionaries\ProjectTag;
use App\Models\Dictionaries\Region;
use App\Models\Project;
use App\Models\ProjectsProjectTags;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectForm extends Component
{
    use WithFileUploads, FileUploader;

//    Словари
    public $regions, $categories, $tags;
    //    Свойства проекта
    /** @var string */
    public $project, $description, $amount, $project_tags, $end_date, $title, $short_desc, $region_id, $category_id;
    public $project_card, $project_image, $project_video;

    //    Свойства вознаграждения
    public $award_on_edit;
    public $award_title, $award_desc, $award_quantity, $award_cost, $is_unlim = false;

    //  project rules for validation
    protected $rules = [
        'title' => ['required', 'max:250'],
        'short_desc' => ['required', 'max:500'],
        'amount' => ['required', 'integer', 'min:1000'],
        'description' => ['required', 'max:4000'],
        'end_date' => ['required', 'date'],
        'region_id' => ['required'],
    ];

    protected $listeners = ['awardUpdated' => '$refresh'];

    private function is_author($project)
    {
        //  Проверка что текущий юзер - автор
        if (Auth::id() != $project->user_id) {
            abort(404);
        }
    }

    //  Сохранение проекта
    public function save()
    {
        $this->validate();
        $user_id = Auth::id();

        //   Создание нового или определение текущего
        if (isset($this->project)) {
            $cur_project = Project::find($this->project->id);
            $this->is_author($cur_project);
        } else {
            $cur_project = new Project;
        }

        //   Внесение данных
        $cur_project->title = $this->title;
        $cur_project->short_desc = $this->short_desc;
        $cur_project->amount = $this->amount;
        $cur_project->description = $this->description;
        $cur_project->end_date = $this->end_date;
        $cur_project->user_id = $user_id;
        $cur_project->is_public = false;
        $cur_project->category_id = ($this->category_id == '') ? null : $this->category_id;
        $cur_project->region_id = $this->region_id;

        $cur_project->save();

//        Удаление всех прошлых тэгов
        ProjectsProjectTags::where('project_id', $cur_project->id)->delete();
//        Внесение новых
        foreach ($this->project_tags as $tag) {
            ProjectsProjectTags::updateOrCreate([
                'project_id' => $cur_project->id,
                'project_tag_id' => $tag,
            ]);
        }
        //      Если проект новый переводим на страницу редактирования
        if (isset($this->project)) {
            $this->project = $cur_project;
            session()->flash('project_msg', 'Проект сохранен');
        } else {
            return redirect()->intended(route('project.edit', ['project' => $cur_project->id]))
                ->with('project_msg', 'Проект сохранен');
        }
    }

    //   Сохранение медиа файлов, 2 шаг
    public function saveMedia()
    {
        if (!isset($this->project)) {
            session()->flash('media_err', 'Заполните данные в разделе Основное и сохраните их');
            return;
        }
//          Проверка что текущий юзер - автор
        $cur_project = Project::find($this->project->id);
        $this->is_author($cur_project);

        $this->validate([
            'project_card' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:4096'],
            'project_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:4096'],
            'project_video' => ['nullable', 'string'],
        ]);
//        Проверка что пользователь добавил одно фото или видео
        if (!isset($this->project_image) && !isset($this->project_video) && !isset($this->project->image_card) && !isset($this->project->video)) {
            $this->addError('video', 'Вы дожны добавить фото или видео для страницы проекта');
        }
//      Загрузка фото на карточку
        if (isset($this->project_card) && $this->project_card != '') {
            $card_path = $this->upload_image($this->project_card, $cur_project->image_card ?? null, 'projects');
            $cur_project->image_card = $card_path;
        }
//      Загрузка фото в шапку
        if (isset($this->project_image) && $this->project_image != '') {
            $image_path = $this->upload_image($this->project_image, $cur_project->image_header ?? null, 'projects');
            $cur_project->image_header = $image_path;
        }

        $cur_project->video = $this->project_video ?? null;

        $cur_project->save();

        $this->project = $cur_project;
        session()->flash('media_scs', 'Медиа файлы успешно сохранены');
    }

//   Сохранение вознаграждений
    public function saveAward()
    {
        if (!isset($this->project)) {
            session()->flash('award_err', 'Заполните данные в разделе Основное и сохраните их');
            return;
        }

//          Проверка что текущий юзер - автор
        $cur_project = Project::find($this->project->id);
        $this->is_author($cur_project);

        $this->validate([
            'award_title' => ['required', 'max:150'],
            'award_desc' => ['required', 'max:1000'],
            'award_quantity' => ['nullable', 'integer'],
            'award_cost' => ['required', 'integer', 'min:100']
        ]);
        $cur_award = $this->award_on_edit ?? new Award;

        $cur_award->title = $this->award_title;
        $cur_award->description = $this->award_desc;
        $cur_award->quantity = $this->is_unlim ? null : ($this->award_quantity ?? null);
        $cur_award->min_cost = $this->award_cost;
        $cur_award->project_id = $cur_project->id;

        $cur_award->save();

        $this->clearAwardForm();

        session()->flash('award_msg', 'Вознаграждение сохранено');
        $this->emit('awardUpdated');
    }

    public function editAward(Award $award)
    {
        $this->award_on_edit = $award;
        $this->award_title = $award->title;
        $this->award_desc = $award->description;
        $this->award_quantity = $award->quantity;
        $this->award_cost = $award->min_cost;
        $this->is_unlim = $award->quantity ? false : true;

    }

    public function deleteAward($award_id)
    {
        $award = Award::find($award_id);
        if (Auth::id() != $award->project->user_id) {
            abort(404);
        }
        $award->delete();
        session()->flash('award_msg', 'Вознаграждение удалено');

        $this->emit('awardUpdated');
    }

//  Clear award form
    public function clearAwardForm()
    {
        $this->award_on_edit = null;
        $this->award_cost = null;
        $this->award_quantity = null;
        $this->award_desc = '';
        $this->award_title = '';
        $this->is_unlim = false;
    }

    public function sendToModerate()
    {
        if (!isset($this->project)) {
            session()->flash('award_err', 'Заполните данные в разделе Основное и сохраните их');
            return;
        }
//          Проверка что текущий юзер - автор
        $cur_project = Project::find($this->project->id);
        $this->is_author($cur_project);

//      Поиск статуса отправлен на модерацию
        $status = ProjectStatus::find(1);

        if (!isset($status)) {
            abort(500);
        }

//       Проверка что текущий статус создается или отправлен на модерацию
        $cur_status = $cur_project->status_id ?? null;
        if ($cur_status == null || $cur_status == 1) {
            $cur_project->update([
                'status_id' => $status->id,
            ]);
            session()->flash('project_msg', 'Проект отправлен на проверку модераторами');
        } else {
            session()->flash('err_msg', 'Проект уже прошел проверку');
        }

        return $this->redirect(route('user.profile'));
    }

//   Construct function
    public function mount($project = null)
    {
        $this->regions = Region::all(['id', 'name']);
        $this->categories = ProjectCategory::all(['id', 'name']);
        $this->tags = ProjectTag::all(['id', 'name']);

        if (isset($project)) {
            $project = Project::find($project);

            if (!isset($project) || ($project->user_id != Auth::id())) {
                abort(404);
            }

            $this->project = $project;
            $this->title = $project->title;
            $this->end_date = $project->end_date;
            $this->amount = $project->amount;
            $this->description = $project->description;
            $this->short_desc = $project->short_desc;
            $this->region_id = $project->region_id;
            $this->project_video = $project->video;
            $this->category_id = $project->category_id;
            $this->project_tags = $project->tags->pluck('id')->toArray() ?? [];
        } else {
            $this->project_tags = [];
        }
    }

    public function render()
    {
        return view('livewire.project.project-form', ['awards' => $this->project->awards ?? [],
        ])->extends('layouts.app');
    }
}
