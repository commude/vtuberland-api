@extends('admin.layouts.app')

@section('title', 'ダッシュボード | 購入者リスト')

@section('contents')
<section class="dashboardPageActionSec dashboard02">
    <div class="dashboardPageActionSec__bar"><a class="btn-backToDashboard" href="{{ route('admin.dashboard.buyer.index') }}">一覧へもどる</a></div>
</section>

<section class="dashboardDetailPage__detailCont">
    <div class="detailContInner">
        <div class="detailContInner__textArea">
            <h4 class="detailContInner__buyerNameText">{{ $user->name }}</h4>
            <p class="detailContInner__deviceNameText">{{ $user->os }}</p>
            <div class="detailContInner__purchaseDetail">
                <div class="detailContInner__purchaseDetailNoText">購入件数：{{ number_format($count) }}件</div>
                <div class="detailContInner__purchaseDetailTotalNoText">購入合計金額：{{ number_format($totalPrice) }}円</div>
            </div>
        </div>
        <div class="detailContInner__tableCont">
            <table class="detailContInner__table">
                <thead>
                    <tr class="detailContInner__row">
                        <td class="detailContInner__itemDateTime">購入日時</td>
                        <td class="detailContInner__itemPurchaseContent">購入コンテンツ</td>
                        <td class="detailContInner__itemPurchasePrice">購入金額</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseList as $purchase)
                    <tr class="detailContInner__row">
                        <td class="detailContInner__itemDateTime">{{ $purchase['purchase_date'] }}</td>
                        <td class="detailContInner__itemPurchaseContent">{{ $purchase['content'] }}</td>
                        <td class="detailContInner__itemPurchasePrice">{{ $purchase['price'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
