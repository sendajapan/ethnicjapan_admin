<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PartDataTable;
use App\Helper\ApiResponseBuilder;
use App\Http\Controllers\Controller;
use App\Models\PartCategory;
use App\Models\PartSale;
use App\Models\Sale;
use App\Models\Vehicle;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PartDataTable $dataTable)
    {
        $makers = Vehicle::select(['make_id', 'make_title'])->orderBy('make_title')->distinct()->get();
        $partCategories = PartCategory::all();

        $cartContent = Cart::content();
        $totalPrice = Cart::subtotal();

        return $dataTable->render('admin.cart.create', compact('makers', 'partCategories', 'cartContent', 'totalPrice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            Cart::add($validated['id'], $validated['name'], $validated['quantity'], $validated['price'], 0, array('max' => $validated['quantity']));

            $cartContent = Cart::content();
            $totalPrice = Cart::subtotal();

            return ApiResponseBuilder::success(
                $validated['name'] . ' added to cart successfully!',
                ['cartContent' => $cartContent, 'totalPrice' => $totalPrice],
                200
            );
        } catch (Exception $e) {
            return ApiResponseBuilder::error(
                'Failed to add product to cart. Please try again later.',
                ['error' => $e->getMessage()],
                500
            );
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $updatedItem = Cart::update($id, $request->qty);
            $totalPrice = Cart::subtotal();

            return ApiResponseBuilder::success(
                ' Updated  to cart successfully!',
                ['updatedItem' => $updatedItem, 'totalPrice' => $totalPrice],
                200
            );
        } catch (Exception $e) {
            return ApiResponseBuilder::error(
                'Failed to add product to cart. Please try again later.',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            Cart::remove($id);
            $cartContent = Cart::content();
            $totalPrice = Cart::subtotal();

            return ApiResponseBuilder::success(
                'Item removed from cart successfully!',
                ['cartContent' => $cartContent, 'totalPrice' => $totalPrice],
                200
            );

        } catch (Exception $e) {
            return ApiResponseBuilder::error(
                'Failed to remove product from cart. Please try again later.',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    public function clear(): RedirectResponse
    {
        Cart::destroy();
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    public function search(Request $request): View
    {
        $searchTerm = $request->get('query');
        $cartContent = Cart::content()->filter(function ($item) use ($searchTerm) {
            return stripos($item->name, $searchTerm) !== false;
        });

        return view('admin.cart.index', compact('cartContent', 'searchTerm'));
    }

    public function checkout(): View
    {
        $cartContents = Cart::content();
        $totalPrice = Cart::subtotal();

        return view('admin.cart.checkout', compact('cartContents', 'totalPrice'));
    }

    public function proceedCheckout(Request $request): RedirectResponse
    {
        $validatedRequest = $request->validate([
            'checkout_discount' => 'required|numeric|min:0',
            'checkout_date' => 'required|date',
            'comment' => 'nullable|string',
        ]);

        $cartContents = Cart::content();

        try {
            DB::beginTransaction();

            $sale = new Sale();
            $sale->quantity_sold = $cartContents->sum('qty');
            $sale->price_at_sale = Cart::subtotal() - intval($validatedRequest['checkout_discount']);
            $sale->comment = $validatedRequest['comment'];
            $sale->sold_at = $validatedRequest['checkout_date'];
            $sale->save();

            foreach ($cartContents as $cartContent) {
                $partSale = new PartSale();
                $partSale->part_id = $cartContent->id;
                $partSale->sale_id = $sale->id;
                $partSale->quantity_sold = $cartContent->qty;
                $partSale->price_at_sale = $cartContent->price;
                $partSale->save();
            }

            DB::commit();

            Cart::destroy();
            return redirect()->route('admin.sale.index')
                ->with('success', 'Sale updated successfully.');

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating data: ' . $exception->getMessage());
        }
    }
}
