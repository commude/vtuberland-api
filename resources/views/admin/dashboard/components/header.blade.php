<header class="dashboardPageHeaderSec">
    <h1 class="dashboardPageHeaderSec__logo">
        <a class="dashboardPageHeaderSec__anchor">
            <img class="dashboardPageHeaderSec__logoThumb" src={{ asset('images/dashboard/dashboardPage_logo.png') }} alt="Logo">
        </a>
        <strong class="dashboardPageHeaderSec__currentPageText">管理画面</strong>
    </h1>
        <a href="../">
            <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
                <input type="submit" value="" class="dashboardPageHeaderSec__logoutButton">
            </form>
        </a>
</header>
