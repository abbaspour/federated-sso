<?php

include 'vars.php';

$domain=$AUTH0_DOMAIN;
$client_id1 = $APP1_CLIENT_ID;
$client_id2 = $APP2_CLIENT_ID;
$app = substr($_SERVER['HTTP_HOST'], 0, 4);

if($app === 'app1') {
    $client_id=$APP1_CLIENT_ID;
    $other_logout=$APP2_LOGOUT_URL;
    $login_page=$APP1_LOGIN_URL;
    $other_client_id=$APP2_CLIENT_ID;
} else if ($app === 'app2') {
    $client_id=$APP2_CLIENT_ID;
    $other_logout=$APP1_LOGOUT_URL;
    $login_page=$APP2_LOGIN_URL;
    $other_client_id=$APP1_CLIENT_ID;
} else {
    die('unknown app: '. $app);
}
$other_app_logout='https://'.$domain.'/v2/logout?client_id='.$other_client_id;
$this_app_logout='https://'.$domain.'/v2/logout?client_id='.$client_id;

setcookie($app, "expired", time() - 3600);

$reload = $_GET['reload'];
if($reload === NULL){
echo ' <iframe src="'. $this_app_logout .'" style="width:0;height:0;border:0; border:none;"></iframe>';  
echo ' <iframe src="'. $other_app_logout .'" style="width:0;height:0;border:0; border:none;"></iframe>';  
echo ' <iframe src="'. $other_logout .'?reload=true" style="width:0;height:0;border:0; border:none;"></iframe>';  
}

echo '<table >';
echo '<tr><td>"Logged out Successfully"</td></tr>';
echo '</table>';

echo '<script>';
echo 'setTimeout(function () { location.href="'.$login_page.'" ; } , 10000); ';
echo '</script>' ;


?>
