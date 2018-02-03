# CloudFlare-pick_away
CloudFlareにキャッシュされたファイルを個別でパージするPHPアプリケーションです。

## Features
pa_purger_master.phpで受け取ったURL一覧の配列はpa_purge_substitute.phpにnohupコマンドを用いて引き渡され，別スレッドで動作します。

これによって，CloudFlareでパージ処理が実行されるまでの待ち時間を裏で処理させることができ，待ち時間の短縮を図ることが出来ます。


## Functions
CloudFlareのAPIを使用し，パージ対象のファイル(URL)をjson形式でdeleteリクエスト(curl)を送る仕組みとなっています。

APIキーなどパラメタはご使用の環境に応じて適宜変更をお願いします。

パージされた結果はログファイルに書き出されます。
