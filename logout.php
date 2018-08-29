<?php
include 'vars.php';

$domain=$AUTH0_DOMAIN;
$app = substr($_SERVER['HTTP_HOST'], 0, 4);

if($app === 'app1') {
    $client_id=$APP1_CLIENT_ID;
    $my_landing=$APP1_LOGIN_URL;
} else if ($app === 'app2') {
    $client_id=$APP2_CLIENT_ID;
    $my_landing=$APP2_LOGIN_URL;
} else {
    die('unknown app: '. $app);
}


$federated_logout='https://'.$domain.'/v2/logout?client_id='.$client_id.'&returnTo='.urlencode($my_landing.'?sso=true');

setcookie($app, "expired", time() - 3600);

header('Location: '.$federated_logout);

exit();

?>
