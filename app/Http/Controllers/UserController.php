<?php

namespace App\Http\Controllers;

use App\Models\User; // <-- Thêm dòng này
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }
}
