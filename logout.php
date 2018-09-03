<?php

include 'vars.php';

$domain = $AUTH0_DOMAIN;
$client_id1 = $APP1_CLIENT_ID;
$client_id2 = $APP2_CLIENT_ID;
$app = substr($_SERVER['HTTP_HOST'], 0, 4);

if ($app === 'app1') {
    $other_logout = $APP2_LOGOUT_URL;
    $login_page = $APP1_LOGIN_URL;
} else if ($app === 'app2') {
    $other_logout = $APP1_LOGOUT_URL;
    $login_page = $APP2_LOGIN_URL;
} else {
    die('unknown app: ' . $app);
}

$other_app_logout = $other_logout . '?sso=true';
$auth0_logout = 'https://' . $domain . '/v2/logout';

setcookie($app, "expired", time() - 3600);

$sso_logout = $_GET['sso'];
if ($sso_logout === 'true') {
    exit();
}

echo '<html><head><title>Logout</title></head><body>';
echo "Logging out...";
echo ' <img src="' . $auth0_logout . '" style="width:0;height:0;border:0; border:none;"/>';
echo ' <img src="' . $other_app_logout . '" style="width:0;height:0;border:0; border:none;"/>';

// TODO: wait for logout succeed e.g. jQuery $(window).on("load", function() { } );
echo '<script type="text/javascript"> setTimeout(function () { location.href="' . $login_page . '" ; } , 5000); </script>';
