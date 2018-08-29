<?php

include 'vars.php';

$domain=$AUTH0_DOMAIN;

$app = substr($_SERVER['HTTP_HOST'], 0, 4);

// app1.com
$client_id_1=$APP1_CLIENT_ID;
$client_secret_1=$APP1_CLIENT_SECRET;
$redirect_uri_1 = $APP1_REDIRECT_URL;
$landing_page_1=$APP1_LANDING_URL;

// app2.com
$client_id_2=$APP2_CLIENT_ID ;
$client_secret_2=$APP2_CLIENT_SECRET;
$redirect_uri_2 = $APP2_REDIRECT_URL;
$landing_page_2=$APP2_LANDING_URL;

if($app === 'app1') {
    $client_id=$client_id_1;
    $client_secret=$client_secret_1;
    $redirect_uri =$redirect_uri_1;
    $landing_page=$landing_page_1;
    $federated_login='https://'.$domain.'/authorize?client_id='.$client_id_2.'&response_type=code&prompt=none&&state='.$app.'sso&nonce=sso1&redirect_uri='.urlencode($redirect_uri_2.'?sso=true');
    $other_app_landing=$landing_page_2;
} else if ($app === 'app2') {
    $client_id=$client_id_2;
    $client_secret=$client_secret_2;
    $redirect_uri =$redirect_uri_2;
    $landing_page=$landing_page_2;
    $federated_login='https://'.$domain.'/authorize?client_id='.$client_id_1.'&response_type=code&prompt=none&state='.$app.'sso&nonce=sso2&redirect_uri='.urlencode($redirect_uri_1.'?sso=true');
    $other_app_landing=$landing_page_1;
} else {
    die('unknown app: '. $app);
}


$authorization_code = $_GET['code'];

if(!$authorization_code){
    die('no authorization_code!');
}

$url = 'https://'.$domain.'/oauth/token';

$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'code' => $authorization_code,
    'grant_type' => 'authorization_code'
 );

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    )
);

$context  = stream_context_create($options);
$result_string = file_get_contents($url, false, $context);

if($result_string === FALSE) {
    die('unable to exchange');
}

$result = json_decode($result_string, true);
//var_dump($result);


$access_token=$result['access_token'];
setcookie($app, $access_token);

$sso_mode = $_GET['sso'];

if($sso_mode === NULL) { // first visit to /cb, send to other app
    header('Location: '.$federated_login);
} else if($sso_mode === 'true') { // sso mode, do not remain here, go back to other app
    header('Location: '.$other_app_landing);
}

exit();

?>
