<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserSpotCharacter;
use App\Http\Resources\Bases\DataTableResource;

class PurchaseController extends Controller
{
    /**
     * Return list of purchases by Datatable's request
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function list(Request $request)
    {
        $search = $request->input('columns')[1]['search']['value'] ?? '';
        $purchases = UserSpotCharacter::offset($request->input('start'))
                        ->whereHasSearchFor('user', 'name', $search)
                        ->limit($request->input('length'))
                        ->orderBy('user_spot_characters.created_at')
                        ->get();

        // Get all count from table.
        $totalCount = UserSpotCharacter::count();

        // Get all Filtered count from table.
        $totalFiltered = UserSpotCharacter::whereHasSearchFor('user', 'name', $search)->count();

        // Get total price
        $priceList = UserSpotCharacter::whereHasSearchFor('user', 'name', $search)->get();
        $totalPrice = 0;
        $totalPrice = $priceList->sum(function ($eachPrice) {
            return $eachPrice->character->price;
        });

        $purchaseList = $purchases->map(function($purchase) {
            return [
                'purchase_date' => $purchase->created_at->format('Y年m月d日'),
                'user_name' => $purchase->user->name,
                'content' => $purchase->character->name,
                'price' => number_format($purchase->character->price).'円',
            ];
        });

        return new DataTableResource($purchaseList, $totalCount, $totalFiltered, $totalPrice);
    }
}
