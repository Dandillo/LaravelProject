<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\NewsController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use App\Models\Block;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', LogoutController::class)
        ->name('logout');
});

//  Информационная страница
Route::get('pages/{page}', function ($page) {
    $page = \App\Models\InfoPage::where('is_public', true)->where('link', $page)->first();
    if (!$page) {
        abort(404);
    }
    return view('page', compact(['page']));
})->name('page');

// Главная страница
Route::get('/', function () {
    $popular_block = \App\Models\Block::where('type', 'popular_projects')->first();
    $popular_projects = $popular_block->projects()->orderByDesc('pivot_weight')->get() ?? [];
    $relevant_block = \App\Models\Block::where('type', 'relevant_projects')->first();
    $relevant_projects = $relevant_block->projects()->orderByDesc('pivot_weight')->get() ?? [];
    $carousel_projects = Block::where('type', 'main_carousel')->first()->projects()->orderByDesc('pivot_weight')->get();

    return view('main', compact(['popular_projects', 'relevant_projects', 'carousel_projects']));
})->name('main');

// Страницы новостей
Route::resource('news', NewsController::class)->only('index', 'show');

// Проекты
Route::get('projects', \App\Http\Livewire\Project\IndexProject::class)->name('project.index');
Route::get('projects/create', \App\Http\Livewire\Project\ProjectForm::class)
    ->name('project.create')->middleware('auth');
Route::get('projects/{project}/edit', \App\Http\Livewire\Project\ProjectForm::class)
    ->name('project.edit')->middleware('auth');
Route::get('projects/{project}', \App\Http\Livewire\Project\ShowProject::class)->name('project.show');

//Новости проекта
Route::get('projects/{project}/news/create', \App\Http\Livewire\Project\ProjectNewsForm::class)
    ->name('project.news.create')->middleware('auth');
Route::get('projects/{project}/news/{news}/edit', \App\Http\Livewire\Project\ProjectNewsForm::class)
    ->name('project.news.edit')->middleware('auth');

// FAQ проекта
Route::get('projects/{project}/faqs', \App\Http\Livewire\Project\ProjectFaqForm::class)
    ->name('project.faqs')->middleware('auth');

// Платежи проекта
Route::middleware('auth')->group(function () {
    Route::get('projects/{project}/payment', [\App\Http\Controllers\PaymentController::class, 'project_payment'])->name('projects.payment');
    Route::post('projects/{project}/yookassa', [\App\Http\Controllers\PaymentController::class, 'requestYookassa'])->name('projects.payment.yoo');
});

Route::any('projects/payment', [\App\Http\Controllers\PaymentController::class, 'store_payment'])->name('projects.payment.store');

// Профиль пользователя
Route::middleware('auth')->group(function () {
    Route::get('profile/edit', \App\Http\Livewire\User\EditProfile::class)->name('user.profile.edit');
    Route::get('profile', \App\Http\Livewire\User\Profile::class)->name('user.profile');
    Route::get('profile/payments', [\App\Http\Controllers\PaymentController::class, 'user_payments'])
        ->name('user.profile.payments');
});

Route::get('user/{user}', [\App\Http\Controllers\UserController::class, 'user_page'])->name('user.page');

//  Административная часть
Route::prefix('admin')->group(function () {

//    Страницы доступные модераторам и администраторам
    Route::middleware('role:admin,moderator')->group(function () {
        Route::get('', \App\Http\Livewire\Admin\Block\AdminPage::class);
        //  Управление Пользователями
        Route::get('users', \App\Http\Livewire\Admin\Users\IndexUsers::class)->name('admin.users');

        //  Модерация проектов
        Route::get('moderate/project-news', \App\Http\Livewire\Admin\Moderate\ProjectNewsModeration::class)
            ->name('admin.moderate.project_news');
        Route::get('moderate/comments', \App\Http\Livewire\Admin\Moderate\CommentModeration::class)
            ->name('admin.moderate.comments');
        Route::get('moderate/faqs', \App\Http\Livewire\Admin\Moderate\FaqModeration::class)
            ->name('admin.moderate.faqs');
        Route::get('moderate/reports', \App\Http\Livewire\Admin\Moderate\ReportModeration::class)
            ->name('admin.moderate.reports');
    });

//    Страницы доступные только администраторам
    Route::middleware('role:admin')->group(function () {
//  Информационная страница
        Route::get('pages', \App\Http\Livewire\Admin\Page\IndexPage::class)->name('admin.pages');
        Route::get('pages/create', \App\Http\Livewire\Admin\Page\PageForm::class)->name('page.create');
        Route::get('pages/{page}/edit', \App\Http\Livewire\Admin\Page\PageForm::class)->name('page.edit');

//  Блоки
        Route::get('blocks', \App\Http\Livewire\Admin\Block\IndexBlock::class)->name('admin.blocks');
        Route::get('blocks/{block}/edit', \App\Http\Livewire\Admin\Block\BlockForm::class)->name('blocks.edit');


//  Новости
        Route::get('news', \App\Http\Livewire\Admin\News\IndexNews::class)->name('admin.news');
        Route::get('news/create', \App\Http\Livewire\Admin\News\NewsForm::class)->name('news.create');
        Route::get('news/{news}/edit', \App\Http\Livewire\Admin\News\NewsForm::class)->name('news.edit');

//  Проекты
        Route::get('project', \App\Http\Livewire\Admin\Project\IndexProject::class)->name('admin.project');
        Route::get('project/applies', \App\Http\Livewire\Admin\Project\ProjectApplies::class)->name('admin.project.applies');
        Route::get('project/{project}/payments', \App\Http\Livewire\Admin\Project\ProjectPayments::class)->name('admin.project.payments');

//  Платежи
        Route::get('refund/{payment}', [\App\Http\Controllers\PaymentController::class, 'refund'])
            ->name('admin.payment.refund');


//  Словари
        Route::get('region', \App\Http\Livewire\Admin\Dictionaries\DictForm::class)->name('admin.region');
        Route::get('project-tag', \App\Http\Livewire\Admin\Dictionaries\DictForm::class)->name('admin.tag');
        Route::get('project-status', \App\Http\Livewire\Admin\Dictionaries\DictForm::class)->name('admin.status');
        Route::get('project-theme', \App\Http\Livewire\Admin\Dictionaries\DictForm::class)->name('admin.theme');
    });
});

Route::get('report', \App\Http\Livewire\ReportForm::class)->name('report');

//  Загрузка изображения
Route::any('upload_image', [\App\Http\Controllers\UploadImageController::class, 'store'])->middleware('auth');
