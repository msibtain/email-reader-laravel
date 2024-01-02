<?php

namespace App\Http\Controllers;

use App\Models\Domain;

use Illuminate\Http\Request;

class DomainsController extends Controller
{
    public function index()
    {
        $domains = Domain::get();

        return view('domains.list', compact('domains'));
    }
}
