<?php

namespace App\Http\Livewire\Admin\Block;

use App\Models\News;
use App\Models\Project;
use Livewire\Component;
use YooKassa\Client;

class AdminPage extends Component
{
    public $projects, $news, $payments;

    public function mount()
    {
        $this->projects = Project::orderBy('updated_at', 'desc')->take(10)->get();
        $this->news = News::orderBy('created_at', 'desc')->take(10)->get();

//      Загрузка Юкассы и данных о послединх платежах
        $shop_id = env('YOOMONEY_SHOP');
        $secret = env('YOOMONEY_SECRET');
        try {
            $client = new Client();
            $client->setAuth($shop_id, $secret);
            $this->payments = $client->getPayments(array('limit'=> 10))->getItems() ?? [];
        } catch (\Exception $exception){
            $this->payments = [];
            session()->flash('err_msg', 'Произошла ошибка загрузки Юкассы. ' . $exception->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.admin.block.admin-page')->extends('layouts.admin');
    }
}
