<header class="dashboardPageHeaderSec">
    <h1 class="dashboardPageHeaderSec__logo">
        <a class="dashboardPageHeaderSec__anchor">
            <img class="dashboardPageHeaderSec__logoThumb" src={{ asset('images/dashboard/dashboardPage_logo.png') }} alt="Logo">
        </a>
        <strong class="dashboardPageHeaderSec__currentPageText">管理画面</strong>
    </h1>
        <a href="javascript:void(0)" onClick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="dashboardPageHeaderSec__logoutButton"></div>
            <form id="logout-form" method="POST" action="{{ route('admin.logout') }}">@csrf</form>
        </a>
</header>
