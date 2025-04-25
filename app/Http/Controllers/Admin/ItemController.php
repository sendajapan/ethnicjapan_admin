<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(ItemsDataTable $dataTable)
    {
        return $dataTable->render('admin.item.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.item.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'max:255',
            'hts_code' => 'max:255'
        ]);

        DB::beginTransaction();

        try {
            $item = new Item();
            $item->item_name = $request->input('item_name');
            $item->item_description = $request->input('item_description');
            $item->hts_code = $request->input('hts_code');

            $item->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $item->item_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.item.index')->with('success', $item->item_name . ' inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Item::where('id', $id)->firstOrFail();

        return view('admin.item.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $name = Item::where('id', $id)->firstOrFail();
            $name->item_name = strtoupper($request->input('item_name'));
            $name->item_description = $request->input('item_description');
            $name->hts_code = $request->input('hts_code');

            $name->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.item.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Item::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Item deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
