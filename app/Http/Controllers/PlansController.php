<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::all()->map(function ($plan) {
            return [
                'id'            => $plan->id,
                'name'          => $plan->name,
                'price'         => $plan->price,
                'duration_days' => $plan->duration_days,
                'benefits'      => $plan->benefits,
            ];
        });
        return response()->json([
            'success' => true,
            'plans'   => $plans
        ]);
    }
}
