<?php

/**

* 【CloudFlare API キャッシュパージプログラム : 裏実行用プログラム】

* このプログラムは，アップロードされたデータのキャッシュを削除するプログラムです。
* pa_purger_master.phpによって呼び出されます。

**/

if ($argv[1] == false){
	die("引数が指定されていません。");
}


function purge($imgurls){

	//ベンチ取り　ログデータに記録される
	$time_start = microtime(true);

	//2秒待機
	//※この処理をしないとオリジンサーバ側の画像が削除される前にパージされることになり，画像が残ってしまいます。
	sleep(2);
	//与えられたURL(imgurls変数)をJSONに整形

	//オリジンサーバ側
	$ZONEID 	= "【ゾーンＩＤ】";
	$API 		= "【ＡＰＩキー】";
	$MAIL		= "【メールアドレス】";

	//CloudFlare側のAPI-URLを指定
	$url 		= "https://api.cloudflare.com/client/v4/zones/".$ZONEID."/purge_cache";
	$curl 		= curl_init($url);

	$options 	= array(

	//CURL実行文を記述
	CURLOPT_HTTPHEADER => array(
	      'Content-Type: application/json',
	      'X-Auth-Key: '.$API,
	      'X-Auth-Email: '.$MAIL,
	),
	//Method
	CURLOPT_CUSTOMREQUEST => "DELETE",//DELETE
	//body
	CURLOPT_POSTFIELDS => $imgurls[0]
	);
	//set options
	curl_setopt_array($curl, $options);
	// request
	$result = curl_exec($curl);

	//処理データのロギング
	$file 		= './purge_result.txt';

	//タイムゾーンの指定
	date_default_timezone_set('Asia/Tokyo');

	//ログの形式を指定。
	$logdate	= date( "Y年m月d日 H時i分s秒" );
	$current 	= file_get_contents($file);
	
	$time 		= microtime(true) - $time_start;


$current .= <<< EOM

実行日時		:	{$logdate}
送信したJSON	:	{$imgurls[0]}
処理時間		:	{$time} 秒
----------------------------------------
EOM;

	file_put_contents($file, $current);

}


	//一応バッファとして結果を出力。
	ob_start();

	purge(array($argv[1]));

	$out = ob_get_contents();
	ob_end_clean();

	//$curfile = file_get_contents('./dump.txt');
	//$export = $curfile .PHP_EOL. $out;
	//file_put_contents('./dump.txt', $export);

exit();