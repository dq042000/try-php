<?php
/**
 * 傳送
 *
 * @param  mixed $method
 * @param  mixed $data
 * @return void
 */
function __curl($method, $data)
{
    // 設定 curl 網址
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);

    // 設定 Header
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Content-Type: multipart/form-data",
    ]);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // 執行
    $output = curl_exec($curl);
    if ($output === false) {
        return ['state' => false, 'data' => curl_error($curl)];
    }
    curl_close($curl);

    return ['state' => true, 'data' => $output];
}

echo "<form method='post' enctype='multipart/form-data'>";
echo "<input hidden name='type' value='1'>";
echo "<input type='file' name='file'>";
echo "<input type='submit' value='送出'>";
echo "</form>";

if (isset($_POST['type']) && $_POST['type'] == 1) {
    $data = [
        'file' => new \CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']),
    ];

    $c = $this->__curl("POST", $data);
    echo "<pre>";
    print_r($c);
    echo "</pre>";
    exit;
}