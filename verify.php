<?php
header("Access-Control-Allow-Origin: [YOUR GITHUB.IO ADDRESS: E.G. https://bwaldon.github.io]");
$secretKey="[YOUR SECRET KEY]";
$response=$_POST["captcha"];

$postdata = http_build_query(["secret"=>$secretKey,"response"=>$response,"remoteip" => $_SERVER['REMOTE_ADDR']]);
$opts = ['http' => 
		[
    	'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
        ]
    ];
$context  = stream_context_create($opts);
$result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
$captcha_success = json_decode($result);

if ($captcha_success->success==false) {
  echo '[$(".loading").hide(), $(".captcha_error").show()]';
}
else if ($captcha_success->success==true) {
  echo "exp.go()";

} 

// Optional: save response data where your php file is stored, as a list of JSON objects

$report_data = json_decode($result,true);

$report_data["ipAddress"] = $_SERVER['REMOTE_ADDR'];
$report_data["timeStamp"] = time();

$report = json_encode($report_data);

// Important: be sure to first create an empty folder titled 'data' in the directory where your 'verify.php' file is located - and to restrict permissions on that folder such that it is inaccessible to general web traffic. 

$myfile = fopen("data/reCaptcha_data.txt", "a") or die("Unable to open file!");
$txt = $report.",";
fwrite($myfile, $txt);
fclose($myfile);



?>

