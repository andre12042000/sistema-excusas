<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {


    }
    public function index()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        return view('admin.user.index');
    }
}
