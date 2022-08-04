<?php
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}

function Capture($str, $starting_word, $ending_word){
  $subtring_start = strpos($str, $starting_word);
  $subtring_start += strlen($starting_word);
  $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
  return trim(preg_replace('/\s\s+/', '', strip_tags(substr($str, $subtring_start, $size))));
};

$lista = $_GET['lista'];
$hashh = multiexplode(array(":", "|", ""), $lista)[0];



$curl = curl_init('https://hashtoolkit.com/decrypt-hash/?hash='.$hashh.'');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Accept: */*',
'accept-language: en-US,en;q=0.9',
  'User-Agent: Mozilla/5.0 (Windows NT '.rand(11,99).'.0; Win64; x64) AppleWebKit/'.rand(111,999).'.'.rand(11,99).' (KHTML, like Gecko) Chrome/'.rand(11,99).'.0.'.rand(1111,9999).'.'.rand(111,999).' Safari/'.rand(111,999).'.'.rand(11,99).''
));
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_COOKIEFILE, $save_cookies);
curl_setopt($curl, CURLOPT_COOKIEJAR, $save_cookies);
 $result = curl_exec($curl);

$decrypt = Capture($result, '>Hashes for: <code>', '</code>');
$type = Capture($result, 'title="decrypted ', ' hash">');

if ((strpos($result, "Decrypt  Hash Results for: "))){
  echo '<span class="badge badge-warning">#Aprovada </span> <span class="badge badge-success"> Decrypted Result : '.$decrypt.' | Hash Type : '.$type.' </span> <br>';
}
elseif ((strpos($result, "No hashes found"))){
  echo '<span class="badge badge-warning">Reprovada ⍋ </span> <span class="badge badge-danger"> Hash Not Found </span> <br>';
}
else {
  echo '<span class="badge badge-warning">Reprovada ⍋ </span> <span class="badge badge-primary"> Error Not Listed </span> <br>';
}

 ?>