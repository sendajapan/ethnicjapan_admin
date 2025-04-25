<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costs = Cost::all();
        return view('admin.cost.index', compact('costs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cost_type' => 'required|string|unique:costs,name',
            'currency' => 'required',
            'default_cost' => 'required|numeric',
            'active' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $cost = new Cost();
            $cost->name = strtoupper($request->input('cost_type'));
            $cost->currency = $request->input('currency');
            $cost->default_cost = $request->input('default_cost');
            $cost->active = $request->input('active');
            $cost->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.cost.index')->with('success', 'Data inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost $cost)
    {
        dd($cost);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
