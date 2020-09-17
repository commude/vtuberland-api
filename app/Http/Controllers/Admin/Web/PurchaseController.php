<?php

namespace App\Http\Controllers\Admin\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserSpotCharacter;
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
        $purchases = UserSpotCharacter::offset($request->input('start'))
                                ->whereHasSearchFor('user', 'name', $search)
                                ->limit($request->input('length'))
                                ->orderBy('user_spot_characters.created_at')
                                ->get();

        // Get all count from table.
        $totalCount = UserSpotCharacter::count();

        // Get all Filtered count from table.
        $totalFiltered = UserSpotCharacter::whereHasSearchFor('user', 'name', $search)
                                    ->count();

        // Get total price
        $priceList = UserSpotCharacter::whereHasSearchFor('user', 'name', $search)->get();
        $totalPrice = 0;
        $totalPrice = $priceList->sum(function ($eachPrice) {
            return $eachPrice->character->price;
        });

        $purchaseList = [];
        foreach ($purchases as $key => $purchase){
            $purchaseList[$key] = [
                "purchase_date" => $purchase->created_at->format('Y-m-d H:m:s'),
                "user_name" => $purchase->user->name,
                "content" => $purchase->character->name,
                "price" => $purchase->character->price,
            ];
        }

        return new DataTable($purchaseList, $totalCount, $totalFiltered, $totalPrice);
    }
}
