<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="description" content="Login - Register Template">
    <meta name="author" content="Lorenzo Angelino aka MrLolok">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/frontend/css/login.css">
    <style>
        body {
            background-color: #303641;
        }
    </style>
</head>

<body>
<div id="container-login">
    @if(Session::has('status'))
        <div class="alert">
            {{Session::get('status')}}
            @endif
    <div id="title">
        <i class="material-icons lock">lock</i> Login
    </div>

    <form action="{{url('/accessaccount')}}" method="POST">
        {{csrf_field()}}        <div class="input">
            <div class="input-addon">
                <i class="material-icons">email</i>
            </div>
            <input id="email" name="email" placeholder="Email" type="email" required class="validate" autocomplete="off">
        </div>

        <div class="clearfix"></div>

        <div class="input">
            <div class="input-addon">
                <i class="material-icons">vpn_key</i>
            </div>
            <input id="password" name="password" placeholder="Password" type="password" required class="validate" autocomplete="off">
        </div>

        <div class="remember-me">
            <input type="checkbox">
            <span style="color: #DDD">Remember Me</span>
        </div>

        <input type="submit" value="Log In" />
    </form>

    <div class="forgot-password">
        <a href="#">Forgot your password?</a>
    </div>
    <div class="privacy">
        <a href="#">Privacy Policy</a>
    </div>

    <div class="register">
        Don't have an account yet?
        <a href="/signup"><button id="register-link">Signup</button></a>
    </div>
</div>
</body>

</html>
