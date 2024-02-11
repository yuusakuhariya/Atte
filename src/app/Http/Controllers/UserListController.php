<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserListController extends Controller
{
    public function userList() {
        $lists = User::paginate(5);

        return view('userList', compact('lists'));
    }
}
