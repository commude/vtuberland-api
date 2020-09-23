@extends('admin.layouts.app')

@section('title', 'ダッシュボード | 購入者リスト')

@section('contents')
<section class="dashboardPageActionSec dashboard02">
    <div class="dashboardPageActionSec__bar">
        <form class="dataListSearchAction">
            <input class="dataListSearchAction__input js--searchInputText" type="text" name="datalist-filterSearch" placeholder="アカウント検索">
            <div class="dataListSearchAction__searchSubmit js--searchFilterSubmit"></div>
        </form>
        <div class="dataListStatus">
            <p class="dataListStatus__text">合計人数：人</p>
        </div>
    </div>
</section>

<section class="dashboardPage__dataList">
    <div class="dataList__fixed">
        <table class="dataList__table" id="userDataList" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="dataList__itemDeviceName02 head">デバイス(iOS/Android)</th>
                    <th class="dataList__itemBuyerName02 head">購入者アカウント名</th>
                    <th class="dataList__itemPurchaseNo02 head">購入件数</th>
                    <th class="dataList__itemPurchaseTotal02 head">購入合計金額</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</section>

<section class="dashboardPage__pagination"></section>

<div class="api_route">{{route('api.admin.buyer.list')}}</div>

@endsection
