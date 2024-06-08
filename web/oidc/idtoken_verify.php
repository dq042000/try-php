<?php
use Namshi\JOSE\JWS;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;

//取回access token
include "config.php";
include "library.class.php";
include '../vendor/autoload.php'; //驗證 id_token 所需套件

session_start();
$obj = new openid();

$jwks_uri = JWKS_URI;
if (DYNAMICAL_ENDPOINT) {
    $jwks_uri = $ep->getEndPoint()->jwks_uri;
}
$jd = $obj->getModnExp($jwks_uri);
if (!$jd) {
    die("無法取得 USER INFO");
}
$e = $jd['keys'][0]['e'];
$n = $jd['keys'][0]['n'];

// 取得public key，需安裝套件
// composer require phpseclib/phpseclib
// https://github.com/phpseclib/phpseclib
$rsa = new RSA();
$nx = new BigInteger($obj->urlsafeB64Decode($n), 256);
$ex = new BigInteger($obj->urlsafeB64Decode($e), 256);

$rsa->loadKey(
    array(
        'e' => $ex,
        'n' => $nx,
    )
);

$pubkey = $rsa->getPublicKey();

// 驗證id token，需安裝套件
// composer require namshi/jose
$id_token = "";
// $JWS = new JWS(array(), 'SecLib');
// $jws = $JWS->load($id_token);
// $p = $jws->getPayload(); //取得payload
// if ($jws->verify($pubkey, 'RS256')) {
//     echo sprintf("ID_TOKEN驗證通過，USER UNIQUE ID= #%s", $p['sub']);
// } else {
//     echo "ID_TOKEN驗證失敗";
// }
try {
    $decoded = JWT::decode($id_token, new Key($pubkey, 'RS256'));
    echo sprintf("ID_TOKEN驗證通過，USER UNIQUE ID= #%s", $decoded->sub);
} catch (\Exception $e) {
    echo "ID_TOKEN驗證失敗" . $e->getMessage();
}
exit;




// // 解析token
// $id_token = "";
// $token = explode('.', $id_token);
// $header = json_decode(base64_decode($token[0]), true);
// $payload = json_decode(base64_decode($token[1]), true);
// $signature = $token[2];
// echo '<pre>';
// print_r($header);
// print_r($payload);
// print_r($signature);
// echo '</pre>';
// exit;
