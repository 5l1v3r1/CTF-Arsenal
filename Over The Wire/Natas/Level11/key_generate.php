<?php

$defaultdata = array( "showpassword"=>"no", "bgcolor"=>"#ffffff");

function xor_encrypt($in,$key) {
    $text = $in;
    $outText = '';

    for($i=0;$i<strlen($text);$i++) {
    $outText .= $text[$i] ^ $key[$i % strlen($key)];
    }

    return $outText;
}
$plaintext = json_encode($defaultdata);
$ciphertext = hex2bin('0a554b221e00482b02044f2503131a70531957685d555a2d121854250355026852115e2c17115e680c');
$key = "qw8J";

$new_data = array( "showpassword"=>"yes", "bgcolor"=>"#ffffff");
$new_plaintext = json_encode($new_data);
$new_ciphertext = xor_encrypt($new_plaintext , $key);
$cookie = base64_encode($new_ciphertext);
echo($cookie);

?>