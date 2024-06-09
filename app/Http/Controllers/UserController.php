<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function user_page(User $user)
    {
        $created_projects = $user->projects->whereNotIn('status_id', [null, 1]);

        $payments = $user->payments()->pluck('project_id');
        $supported_projects = Project::find($payments);

        return view('user.user-page', compact(['user', 'created_projects', 'supported_projects']));
    }

}
