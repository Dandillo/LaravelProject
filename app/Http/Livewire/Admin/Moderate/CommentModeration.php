<?php

namespace App\Http\Livewire\Admin\Moderate;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class CommentModeration extends Component
{
    public $status = null;

//  Подтверждение проверки контента
    public function checked_project_part(Comment $comment)
    {
        $comment->update([
            'is_banned' => false,
        ]);

        session()->flash('scs_msg', 'Данный комментарий проверен');
    }

//  Блокировка контента
    public function block_project_part(Comment $comment)
    {
        if ($comment->is_banned) {
            session()->flash('scs_msg', 'Данный комментарий уже заблокирован');
            return;
        }

        $comment->update([
            'is_banned' => true,
            'ban_date' => now(),
            'banned_admin' => Auth::id(),
        ]);
        session()->flash('scs_msg', 'Данный комментарий успешно заблокирован');
    }

    public function render()
    {
        $comments = Comment::where('is_banned', ($this->status == '') ? null : $this->status)
            ->paginate(Config::get('paginate_count', 20));
        return view('livewire.admin.moderate.comment-moderation', compact('comments'))->extends('layouts.admin');
    }
}
