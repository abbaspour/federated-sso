<?php
$domain='TENANT.au.auth0.com';
$app = substr($_SERVER['HTTP_HOST'], 0, 4);

if($app === 'app1') {
    $client_id='APP1_CLIENT_ID';
    $other_app_logout_url='http://app2.com/~amin/federated-sso/logout.php';
    $other_app_landing='http://app2.com/~amin/federated-sso/login2.html';
    $my_landing='http://app1.com/~amin/federated-sso/login1.html';
} else if ($app === 'app2') {
    $client_id='APP2_CLIENT_ID';
    $other_app_logout_url='http://app1.com/~amin/federated-sso/logout.php';
    $other_app_landing='http://app1.com/~amin/federated-sso/login1.html';
    $my_landing='http://app2.com/~amin/federated-sso/login2.html';
} else {
    die('unknown app: '. $app);
}


$federated_logout='https://'.$domain.'/v2/logout?client_id='.$client_id.'&returnTo='.urlencode($other_app_logout_url.'?sso=true');

setcookie($app, "expired", time() - 3600);

$sso_mode = $_GET['sso'];

if($sso_mode === NULL) { // first visit to /logout, send to other app via /v2/logout
    header('Location: '.$federated_logout);
} else if($sso_mode === 'true') { // sso mode, do not remain here, go back to other app
    header('Location: '.$other_app_landing);
} else {
    header('Location: '.$my_landing);
}

exit();

?>
