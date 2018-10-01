<?php

function countPages($link){
	$curl_url = "https://docs.google.com/gview?embedded=true&url=". $link;
	$ch =  curl_init();
	$headers = array(
	    'Cache-Control: max-age=0',
	    'Accept: text/html',
		'Referer: '. $curl_url,
	);
	curl_setopt($ch, CURLOPT_URL, $curl_url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$result =  curl_exec($ch);
	curl_close($ch);

	if(strpos($result, "press?id\u003d") !== false){
		$id = explode("press?id\u003d", $result);
		$id = explode(",", $id[1]);
		$id = substr($id[0], 0, -1);
		
		$curl_url = "https://docs.google.com/viewerng/meta?id=". $id;
		$ch =  curl_init();
		$headers = array(
		    'Cache-Control: max-age=0',
		    'Accept: text/html'
		);
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result =  curl_exec($ch);
		curl_close($ch);
		
		$jsonPages = explode("}'", $result);
		$jsonPages = json_decode($jsonPages[1], 1);
		
		return $jsonPages['pages'];
	}else{
		return "-1";
	}
}

$link = $_GET['link'];
if(!empty($link)){
	echo "Number of pages: ". countPages($link);
}else{
	echo "Insert a link to count the number of pages";
}

?>
