前提環境
----
- PHP version 7.*.* 以上
- composer がinstallされていること



InstallをしてProjectを作成しよう
----

- Install方法は、2種類あります

```shell
composer create-project laravel/laravel testApp #今回は、testAppとしてます 
```
もしくは、以下のコマンドを実行してもInstallは可能です

```shell
composer global require "laravel/installer"
laravel new testApp
```


また上記に付随しオプションでversion指定をすることも可能で、以前のversionを指定してのProject作成も可能です



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
