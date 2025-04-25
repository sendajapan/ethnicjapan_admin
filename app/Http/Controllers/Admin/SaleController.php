<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::with(['parts.partName', 'parts.vehicle'])->get();
        return view('admin.sale.index', compact('sales'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'quantity_sold' => 'required|integer',
            'price_at_sale' => 'required|numeric',
            'part_ids' => 'required|array',
            'part_ids.*' => 'exists:parts,id',
        ]);

        $sale = Sale::create([
            'quantity_sold' => $request->quantity_sold,
            'price_at_sale' => $request->price_at_sale,
            'sold_at' => now(),
        ]);

        foreach ($request->part_ids as $partId) {
            $sale->parts()->attach($partId, [
                'quantity' => $request->quantity_sold,
                'price_at_sale' => $request->price_at_sale,
            ]);
        }

        //return redirect()->route('admin.sales.index')->with('success', 'Sale created successfully.');
        return redirect()->route('admin.dashboard')->with('success', 'Sale created successfully.');
    }
}
