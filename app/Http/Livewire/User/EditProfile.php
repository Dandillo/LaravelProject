<?php

namespace App\Http\Livewire\User;

use App\Models\Dictionaries\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public $name, $phone, $birthdate, $sex, $about, $photo,$cur_photo, $region_id;
    public $regions;

    public $image_file_path;

    protected $rules = [
        'name' => ['required', 'max:250'],
        'phone' => ['max:15', 'nullable'],
        'birthdate' => ['date', 'nullable'],
        'sex' => ['nullable', 'in:female,male'],
        'about' => ['nullable', 'max:2000'],
        'photo' => ['image', 'max:4096', 'mimes:jpg,jpeg,png,svg,gif', 'nullable'],
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->birthdate = $user->birthdate;
        $this->sex = $user->sex;
        $this->about = $user->about;
        $this->region_id = $user->region_id;
        $this->cur_photo = $user->photo;

        $this->regions =Region::all();
        $this->image_file_path = storage_path('app/public/users');
    }

    public function save()
    {
        $this->validate();
        if (!Auth::check()) {
            abort(500);
        }
        $user = Auth::user();

        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
            'about' => $this->about,
            'region_id' => ($this->region_id == '') ? null : $this->region_id,
        ]);

        if ($this->photo) {
//      Если есть, удаляем старое
            if (isset($user->photo)) {
                Storage::delete('public/' . $user->photo);
            }
//      Сохранение фото пользователя
            $photo_name = $this->photo->hashName();
            $photo_img = Image::make($this->photo->path());
            $photo_img->fit(800, 800)->save($this->image_file_path . '/' . $photo_name);
            $user->photo = $photo_name ? ("users/" . $photo_name) : null;
            $user->save();
        }

        session()->flash('scs_msg', 'Данные успешно обновлены');
    }

    public function render()
    {
        return view('livewire.user.edit-profile');
    }

}
