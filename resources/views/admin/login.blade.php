<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>Login | Niijisanji</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1, viewport-fit=cover">
    {{--
    <meta name="keywords" content="this is meta keyworks">
    <meta name="description" content="this is meta description">
    <meta property="og:title" content="Niijisanji">
    <meta property="og:type" content="website">
    <meta property="og:description" content="this is meta description">
    <meta property="og:url" content="http://website.com">
    <meta property="og:image" content="../../public/images/_etc/ogp.jpg">
    <meta property="fb:app_id" content="XXXXXXXXXXXXXXXX">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@XXXXX">
    <meta name="twitter:creator" content="@XXXXX">
    <meta name="twitter:image:src" content="../../public/images/_etc/ogp.jpg">
    <link rel="icon" type="image/x-icon" href="../../public/images/_etc/favicon.ico">
    <link rel="icon" type="image/png" href="../../public/images/_etc/favicon.png">
    <link rel="apple-touch-icon" type="image/png" href="../../public/images/_etc/custom-icon.png">
    --}}

    <!-- Styles-->
    <link rel="stylesheet" media="print,screen" href={{ asset('css/app.css') }}>
  </head>
  <body class="loginPage">
    <main class="siteContent">
      <section class="loginPageLoginSec">
        <div class="loginPageLoginSec__inner">
          <figure class="loginPageLoginSec__logoThumb"><img src={{ asset('images/dashboard/login/loginPage_logo.png') }} alt="Logo"></figure>
          <div class="loginPageLoginSec__innerLoginArea">
            <form method="POST" action="{{ route('admin.login') }}">
            @csrf
              <div class="loginPageLoginSec__inputTextField">
                <div class="loginPageLoginSec__inputUserField">
                  <input class="loginPageLoginSec__inputText" type="email" name="email" placeholder="メールアドレス">
                </div>
                @error('email')
                    <span class="loginPageLoginSec__inputLabel" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                <div class="loginPageLoginSec__inputPassField">
                  <input class="loginPageLoginSec__inputText" type="password" name="password" placeholder="パスワード">
                </div>
                @error('password')
                    <span class="loginPageLoginSec__inputLabel" role="alert">
                        {{ $message }}
                    </span>
                @enderror
              </div>
              <div class="loginPageLoginSec__inputCheckField">
                <div class="loginPageLoginSec__inputCheckCont">
                  <input class="loginPageLoginSec__inputCheck" type="checkbox" name="form-remember">
                  <div class="loginPageLoginSec__checkmark"></div>
                </div>
                <label for="form-remember"><span class="loginPageLoginSec__inputLabel">ログイン情報を保存する</span></label>
              </div>
              <div class="loginPageLoginSec__buttonField">
                <input class="loginPageLoginSec__loginButton" type="submit" value="ログイン">
              </div>
            </form>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>
