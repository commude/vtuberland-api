<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\User;
use App\Enums\Character;
use Illuminate\Http\Request;
use App\Models\SpotCharacter;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.buyers.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\\User  $user
     * @return \Illuminate\Http\Response
     */
    public function user(User $user)
    {
        $spotCharacter = new SpotCharacter;

        $totalPrice = $user->spotCharacters->sum(function ($purchase) use ($spotCharacter) {
            return $spotCharacter->where('spot_id', $purchase->spot_id)->where('character_id', $purchase->character_id)->first()->price;
        });

        $count = $user->spotCharacters->count();

        $purchaseList = $user->spotCharacters->map(function($purchase) use ($spotCharacter) {
            return [
                'purchase_date' => $purchase->created_at->format('Y年m月d日'),
                'content' => Character::getJPName($purchase->character->name),
                'price' => number_format($spotCharacter->where('spot_id', $purchase->spot_id)->where('character_id', $purchase->character_id)->first()->price).'円',
            ];
        })->sortByDesc('purchase_date');

        return view('admin.dashboard.buyers.user')->with(compact(['user', 'count', 'totalPrice', 'purchaseList']));
    }
}
