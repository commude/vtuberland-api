@extends('admin.layouts.app')

@section('title', 'ダッシュボード | 購入履歴')

@section('contents')
<section class="dashboardPageActionSec">
  <div class="dashboardPageActionSec__bar">
    <form id="deleteForm" class="dataListFilterAction" method="POST" action="{{ route('admin.purchase.delete') }}">
    @csrf
      <div class="dataListFilterAction__filterOption">
        <input class="dataListFilterAction__filterInput js--selectAll" type="checkbox" name="datalist-selectAll">
        <div class="dataListFilterAction__filterCusCheck"></div>
      </div>
      <div class="dataListFilterAction__filterSubmit js--deleteSubmit">削除する</div>
    </form>
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
                    <td class="dataList__itemSelect head"></td>
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
@endsection
