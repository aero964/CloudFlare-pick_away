<?php


/**

* 【CloudFlare API キャッシュパージプログラム : 呼び出し用プログラム】

* このプログラムは，アップロードされたデータのキャッシュを削除するプログラムです。

* @param $imageIDs 画像ＩＤが格納されている配列

**/


$p1 = array("https://someurl/dummyfile");

foreach ($arrayID as $imageIDs) {

	$imageIDs = "https://someurl/".$imageIDs;

	array_push(
		$p1,
		$imageIDs,
		$imageIDs.".jpg",
		$imageIDs.".JPG",
		$imageIDs.".jpeg",
		$imageIDs.".JPEG",
		$imageIDs.".gif",
		$imageIDs.".GIF",
		$imageIDs.".png",
		$imageIDs.".PNG"
	);

}


$p1	= json_encode(array("files"=>$p1), JSON_UNESCAPED_SLASHES);


exec("nohup php -c '' '/path/to/pa_purger_substitute.php' '".$p1."' > /dev/null &");
