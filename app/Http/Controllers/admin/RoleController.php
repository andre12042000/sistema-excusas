<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }}
