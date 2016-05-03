<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <title>Cluj Startup</title>
    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>
<body>

<p><a href="#" onClick="logInWithFacebook()">Log In with the JavaScript SDK</a></p>
<div class="result"></div>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
        logInWithFacebook = function () {
            FB.login(function (response) {
                if (response.authResponse) {
                    alert('You are logged in &amp; cookie set!');
                    $.post("http://startup-back.dev:8000/api/v1/facebook-login", function (data) {
                        console.log(data)
                        $(".result").html(data);
                    });
                } else {
                    alert('User cancelled login or did not fully authorize.');
                }
            });
            return false;
        };
        window.fbAsyncInit = function () {
            FB.init({
                appId: "{{config('social_oauth.facebook_id')}}",
                cookie: true, // This is important, it's not enabled by default
                version: 'v2.6'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "http://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    });
</script>
</body>
</html>