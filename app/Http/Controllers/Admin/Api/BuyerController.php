<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\User;
use App\Models\UserSpotCharacter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bases\DataTableResource;

class BuyerController extends Controller
{
    /**
     * Return list of user by Datatable's request
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function list(Request $request)
    {
        $filter = $request->input('columns')[1]['search']['value'] ?? '';
        $users = User::offset($request->input('start'))
                    ->orSearchFor('name', $filter)
                    ->limit($request->input('length'))
                    ->orderBy('users.name')
                    ->get();

        // Get all count from table.
        $totalCount = User::count();

        // Get all Filtered count from table.
        $totalFiltered = User::orSearchFor('name', $filter)->count();

        $userList = $users->map(function($user) {
            return [
                "id" => $user->id,
                "os" => $user->os,
                "user_name" => $user->name,
                "purchase_num" => number_format($user->spotCharacters->count()),
                "sum_price" => number_format($user->spotCharacters->sum(function($spotCharacter) {
                    return $spotCharacter->character->price;
                })).'円',
            ];
        });

        return new DataTableResource($userList, $totalCount, $totalFiltered, $totalCount);
    }
}
