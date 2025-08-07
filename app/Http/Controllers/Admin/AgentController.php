<?php

namespace App\Http\Controllers;

use App\DataTables\AgentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AgentDataTable $dataTable)
    {
        return $dataTable->render('admin.agent.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.agent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
            'agent_name' => 'required|string|max:255',
            'agent_email' => 'max:255'
        ]);

         DB::beginTransaction();

        try {
            $Agent = new Agent();
            $Agent->agent_name = $request->input('agent_name');
            $Agent->agent_description = $request->input('agent_description');

            $Agent->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $Agent->agent_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.agent.index')->with('success', $Agent->agent_name . ' inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $data = Agent::where('id', $id)->firstOrFail();

        return view('admin.agent.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $Name = Category::where('id', $id)->firstOrFail();
            $Name->category_name = strtoupper($request->input('category_name'));
            $Name->category_description = $request->input('category_description');

            $Name->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.category.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
