<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AtteController extends Controller
{
    public function stamp()
    {
        return view('stamp');
    }
}
