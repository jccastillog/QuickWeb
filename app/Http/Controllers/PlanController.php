<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('clients')->ordered()->get();

        return view('pageadmin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('pageadmin.plans.form', ['plan' => new Plan(['active' => true])]);
    }

    public function store(PlanRequest $request)
    {
        Plan::create($request->validated());

        return redirect()->route('plans.index')->with('success', 'Plan creado');
    }

    public function edit(Plan $plan)
    {
        return view('pageadmin.plans.form', compact('plan'));
    }

    public function update(PlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());

        return redirect()->route('plans.index')->with('success', 'Plan actualizado');
    }
}
