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
     *
     * @return \Illuminate\Http\Response
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
                                ->join('users', 'transactions.user_id', '=', 'users.id')
                                ->join('spot_characters', 'transactions.spot_character_id', '=', 'spot_characters.id')
                                ->join('characters', 'spot_characters.character_id', '=', 'characters.id')
                                ->orWhere('users.name', 'LIKE', "%{$search}%")
                                ->limit($request->input('length'))
                                ->select('transactions.id','transactions.created_at','users.name as userName','characters.name as charaName','characters.price' )
                                ->orderBy('transactions.created_at')
                                ->get();

        // Get all count from table.
        $totalCount = Transaction::count();

        // Get all Filtered count from table.
        $totalFiltered = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
                                    ->orWhere('users.name', 'LIKE', "%{$search}%")
                                    ->count();

        foreach ($purchases as $key => $purchase){
            $tmpList = [
                "purchase_id" => $purchase->id,
                "purchase_date" => $purchase->created_at,
                "user_name" => $purchase->userName,
                "content" => $purchase->charaName,
                "price" => $purchase->price,
            ];
            $purchaseList[$key] = $tmpList;
        }

        return new DataTable($purchaseList, $totalCount, $totalFiltered); 
    }
}
