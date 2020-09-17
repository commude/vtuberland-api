<?php

namespace App\Http\Controllers\Admin\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Http\Resources\Bases\DataTableResource as DataTable;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard.purchases.history');
    }

    /**
     * Return list of purchases by Datatable's request
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function purchaseList(Request $request)
    {
        $search = $request->input('columns')[2]['search']['value'] ?? '';
        $purchases = Purchase::offset($request->input('start'))
                                ->whereHasSearchFor('user', 'name', $search)
                                ->limit($request->input('length'))
                                ->orderBy('purchases.created_at')
                                ->get();

        // Get all count from table.
        $totalCount = Purchase::count();

        // Get all Filtered count from table.
        $totalFiltered = Purchase::whereHasSearchFor('user', 'name', $search)
                                    ->count();

        // Get total price
        $priceList = Purchase::whereHasSearchFor('user', 'name', $search)->get();
        $totalPrice = 0;
        foreach ($priceList as $eachPrice){
            $totalPrice += $eachPrice->spotCharacter[0]->character->price;
        }

        $purchaseList = [];
        foreach ($purchases as $key => $purchase){
            $purchaseList[$key] = [
                "purchase_date" => $purchase->created_at->format('Y-m-d H:m:s'),
                "user_name" => $purchase->user->name,
                "content" => isset($purchase->spotCharacter[0]) ? $purchase->spotCharacter[0]->character->name : '',
                "price" => isset($purchase->spotCharacter[0]) ? $purchase->spotCharacter[0]->character->price : '',
            ];
        }

        return new DataTable($purchaseList, $totalCount, $totalFiltered, $totalPrice);
    }
}
