<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\User;
use App\Models\UserSpotCharacter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bases\DataTableResource as DataTable;

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
    public function show()
    {
        return view('admin.dashboard.buyers.show');
    }

    /**
     * Return list of user by Datatable's request
     * 
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function userList(Request $request)
    {
        $search = $request->input('columns')[1]['search']['value'] ?? '';
        $users = User::offset($request->input('start'))
                                ->orWhere('name', 'LIKE', "%{$search}%")
                                ->limit($request->input('length'))
                                ->orderBy('users.name')
                                ->get();

        // Get all count from table.
        $totalCount = User::count();

        // Get all Filtered count from table.
        $totalFiltered = User::orWhere('name', 'LIKE', "%{$search}%")
                                    ->count();

        // Get total num
        $totalNum = 0;
        $totalNum = User::get()->count();

        $userList = [];
        foreach ($users as $key => $user){

            $purchase_num = 0;
            $sum_price = 0;

            foreach ($user->spotCharacters as $purchase){
                $purchase_num += 1;
                $sum_price += $purchase->character->price;
            }

            $userList[$key] = [
                "id" => $user->id,
                "os" => $user->os,
                "user_name" => $user->name,
                "purchase_num" => $purchase_num,
                "sum_price" => $sum_price,
            ];
        }

        return new DataTable($userList, $totalCount, $totalFiltered, $totalNum); 
    }
}
