<?php

namespace App\Http\Livewire\Admin\Moderate;

use App\Models\Comment;
use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class FaqModeration extends Component
{
    public $status = null;

//  Подтверждение проверки контента
    public function checked_project_part(Faq $faq)
    {
        $faq->update([
            'is_banned' => false,
        ]);

        session()->flash('scs_msg', 'Данный faq проверен');
    }

    //  Блокировка контента
    public function block_project_part(Faq $faq)
    {
        if ($faq->is_banned) {
            session()->flash('scs_msg', 'Данный faq уже заблокирован');
            return;
        }

        $faq->update([
            'is_banned' => true,
            'ban_date' => now(),
            'banned_admin' => Auth::id(),
        ]);
        session()->flash('scs_msg', 'Данный faq успешно заблокирован');
    }

    public function render()
    {
        $faqs = Faq::where('is_banned', ($this->status == '') ? null : $this->status)->where('is_public', true)
            ->paginate(Config::get('paginate_count', 20));
        return view('livewire.admin.moderate.faq-moderation', compact('faqs'))->extends('layouts.admin');
    }
}
