
InstallをしてProjectを作成しよう
----

- Install方法は、2種類ありますが今回は、下記のコマンドで実行します

```shell
composer create-project laravel/laravel --prefer-dist testApp
```
 
コマンド内にあるオプションで`--prefer-dist` というのがありますがこれは、安定板を指定してます
 
また上記に付随しオプションでversion指定を行っています。5.5系がサポート期間が一番長く、セキュリティー修正も長いですがあくまで今回は学習なので気にせず最新版を使用します。
 
 
Serverを立ち上げる
----
以下のコマンドを実行しProjectのディレクトリに移動しサーバーを立ち上げてみます
```shell
cd testApp
php artisan serve
```

実行後以下のように表示されたら問題なくサーバーが立ち上がりブラウザでの確認が可能です
**Laravel development server started: <http://127.0.0.1:8000>**

実際にアクセスしてみましょう
以下のような画面が表示されれば問題ありません
