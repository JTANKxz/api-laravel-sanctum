<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class SubscriptionController extends Controller
{
    public function index() 
    {
        $plans = Plan::all();

        //make compact 
        return view('admin.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store()
    {
    }
}
