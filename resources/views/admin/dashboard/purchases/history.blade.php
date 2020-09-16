@extends('admin.layouts.app')

@section('title', 'ダッシュボード | 購入履歴')

@section('contents')
<section class="dashboardPageActionSec">
  <div class="dashboardPageActionSec__bar">
    <form class="dataListSearchAction">
      <input class="dataListSearchAction__input js--searchInputText" type="text" name="datalist-filterSearch" placeholder="アカウント検索">
      <div class="dataListSearchAction__searchSubmit js--searchFilterSubmit"></div>
    </form>
    <div class="dataListStatus">
      <p class="dataListStatus__text">合計金額：円</p>
    </div>
  </div>
</section>

<section class="dashboardPage__dataList">
    <div class="dataList__fixed">
        <table class="dataList__table" id="dataList" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <td class="dataList__itemPurchaseDate head">購入日時</td>
                    <td class="dataList__itemBuyerAccount head">購入者アカウント名</td>
                    <td class="dataList__itemBuyerContent head">購入コンテンツ</td>
                    <td class="dataList__itemPurchasePrice head">購入金額</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </section>

<section class="dashboardPage__pagination"></section>

<div class="api_route">{{route('admin.purchase.list')}}</div>
@endsection
