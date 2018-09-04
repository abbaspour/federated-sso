<?php
include 'vars.php';

$domain = $AUTH0_DOMAIN;
$app = substr($_SERVER['HTTP_HOST'], 0, 4);

if ($app === 'app1') {
    $client_id = $APP1_CLIENT_ID;
    $other_app_login_url = $APP2_LOGIN_URL;
    $redirect_url = urlencode($APP1_REDIRECT_URL);
} else if ($app === 'app2') {
    $client_id = $APP2_CLIENT_ID;
    $other_app_login_url = $APP1_LOGIN_URL;
    $redirect_url = urlencode($APP2_REDIRECT_URL);
} else {
    die('unknown app: ' . $app);
}

echo "
<html>
    <head>
    <title>$app - Login</title>
    <head>
    <body>
    Welcome to $app<br/>
    <a href=\"https://$domain/authorize?client_id=$client_id&response_type=code&redirect_uri=$redirect_url&state=$app&nonce=$app&scope=openid%20profile&prompt=login\">Login</a>
    <br/>
    <a href=\"$other_app_login_url\">switch to other app</a>
    </body>
</html>";
