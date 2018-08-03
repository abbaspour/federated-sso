<?php

$app = substr($_SERVER['HTTP_HOST'], 0, 4);

if($app === 'app1') {
    $other_app='http://app2.com/~amin/federated-sso/app.php';
} else if ($app === 'app2') {
    $other_app='http://app1.com/~amin/federated-sso/app.php';
} else {
    die('unknown app:'.$app);
}

echo '<table >';
echo '<tr><td>Current App</td><td>'.$app.'</td></tr>';
echo '<tr><td>Other App</td><td><a href="'.$other_app.'">switch</a></td></tr>';
echo '<tr><td>Cookie</td><td>' . htmlspecialchars($_COOKIE[$app]).'</td></tr>';
echo '</table>';

echo '<br/><a href="logout.php">Logout</a>';

?>
