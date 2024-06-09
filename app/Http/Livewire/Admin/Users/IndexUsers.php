<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class IndexUsers extends Component
{
    public $search = '', $ban_desc;

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(Config::get('paginate_count'));
        return view('livewire.admin.users.index-users', compact('users'))->extends('layouts.admin');
    }

    public function get_ban($user_id)
    {
        $user = User::find($user_id);

        if (!Auth::user()->hasRole('admin', 'moderator') || !isset($user_id)) {
            abort(404);
        }

        $user->update([
            'is_banned' => true,
            'ban_desc' => $this->ban_desc,
        ]);
        $this->ban_desc = '';
        session()->flash('scs_msg', 'Пользователь ' . $user->name . ' заблокирован');
    }

    public function get_unban($user_id)
    {
        $user = User::find($user_id);

        if (!Auth::user()->hasRole('admin', 'moderator') || !isset($user_id)) {
            abort(404);
        }

        $user->update([
            'is_banned' => false,
            'ban_desc' => null,
        ]);

        session()->flash('scs_msg', 'Пользователь ' . $user->name . ' разрблокирован');
    }
}
