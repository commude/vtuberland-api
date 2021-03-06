<!DOCTYPE html>
<html lang="ja">
  <head>
      @include('admin.dashboard.components.head')
  </head>
  <body class="dashboardPage">
    @include('admin.dashboard.components.header')
    @include('admin.dashboard.components.nav')
    <main class="siteContent" role="main">
        @yield('contents')
    </main>
    @include('admin.dashboard.components.scripts')
    @stack('script')
  </body>
</html>
