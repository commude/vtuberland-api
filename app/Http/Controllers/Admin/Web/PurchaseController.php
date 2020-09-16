<?php

namespace App\Http\Controllers\Admin\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Resources\Bases\DataTableResource as DataTable;
use App\Http\Resources\TransactionResource;

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
        $purchases = Transaction::offset($request->input('start'))
                                ->whereHasSearchFor('user', 'name', $search)
                                ->limit($request->input('length'))
                                ->orderBy('transactions.created_at')
                                ->get();

        // Get all count from table.
        $totalCount = Transaction::count();

        // Get all Filtered count from table.
        $totalFiltered = Transaction::whereHasSearchFor('user', 'name', $search)
                                    ->count();

        // Get total price
        $priceList = Transaction::whereHasSearchFor('user', 'name', $search)->get();
        $totalPrice = 0;
        foreach ($priceList as $eachPrice){
            $totalPrice += $eachPrice->spotCharacter[0]->character->price;
        }

        $purchaseList = [];
        foreach ($purchases as $key => $purchase){
            $purchaseList[$key] = [
                "purchase_date" => $purchase->created_at->format('Y-m-d H:m:s'),
                "user_name" => $purchase->user->name,
                "content" => $purchase->spotCharacter[0]->character->name,
                "price" => $purchase->spotCharacter[0]->character->price,
            ];
        }

        return new DataTable($purchaseList, $totalCount, $totalFiltered, $totalPrice); 
    }
}
