<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログインフォーム</title>
  <!-- script -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/signin.css') }}" rel="stylesheet">
</head>

<body>
<form class="form-signin" method="POST" action="{{ route('login') }}">
  @csrf
  <h1 class="h3 mb-3 font-weight-normal">ログインフォーム</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <!-- <x-alert type="danger" :session="session('login_error')"/>
  <x-alert type="danger" :session="session('logout')"/> -->
  <!-- 簡素化 -->
  <x-alert type="danger" :session="session('danger')"/>  

  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
</form>
</body>

</html>