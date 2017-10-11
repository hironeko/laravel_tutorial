# Viewの分割を行う

前回までは、一つのfileにごそっと書いたままでしたがこの章では、分割を行います。
この章での目的は、機能毎にViewのfileを用意し、共通部分は、テンプレートを使用し画面の大枠の完成を目指します。

## ページごとにfileを作成します。

今回必要となるページは、新規作成・更新/編集・一覧画面の以上3ページになると思います。
前回の章で作成したのは、一覧画面に使えるhtmlを作成しました。なので前回作成したものを流用し作成していきたいと思います。

Macの方はコマンドでfileを作成しましょう。
```shell
touch resource/views/todo/index.blade.php
```
作成されたfileをエディタで開き記述を行います。この際、前回作成したfileから流用しますがそれに伴い前回のfileの変更も行います。

編集file `resources/views/todo/index.blade.php`

```html
<div class="container">
    <h2 class="page-header">ToDo一覧</h2>

    <p class="pull-right">
        <a class="btn btn-success" href="/todo/create">追加</a>
    </p>

    <table class="table table-hover todo-table">
        <thead>
            <tr>
                <th>やること</th>
                <th>作成日時</th>
                <th>更新日時</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>静的なTodoです</td>
                <td>2017-01-01 00:00:00</td>
                <td>2017-01-10 00:00:00</td>
                <td><a class="btn btn-info" href="">編集</a></td>
                <td><button class="btn btn-danger" type="submit">削除</button></td>
            </tr>
        </tbody>
    </table>

</div>
```

ただしこのままでは、使用ができません。
なので使用できるように記述を加えていきます。初めてみる単語などが出てきますがfileの編集が終わり次第説明をします。

その前にテンプレートの方にも手を加えます。

対象file `resources/views/layout/app.blade.php` です。
```html
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .todo-table td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>

    @yield('content') <!-- 追記 -->

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

</body>
</html>
```

対象file `resources/views/todo/index.blade.php` です。

```html
@extends('layout.app') <!-- 追記 -->
@section('content')  <!-- 追記 -->
<div class="container">
    <h2 class="page-header">ToDo一覧</h2>

    <p class="pull-right">
        <a class="btn btn-success" href="/todo/create">追加</a>
    </p>

    <table class="table table-hover todo-table">
        <thead>
            <tr>
                <th>やること</th>
                <th>作成日時</th>
                <th>更新日時</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>静的なTodoです</td>
                <td>2017-01-01 00:00:00</td>
                <td>2017-01-10 00:00:00</td>
                <td><a class="btn btn-info" href="">編集</a></td>
                <td><button class="btn btn-danger" type="submit">削除</button></td>
            </tr>
        </tbody>
    </table>

</div>
@endsection <!-- 追記 -->
```
追記箇所は、3箇所となります。
- 以下に出てくる用語の共通点
  - 外部読み込みが可能です。要するに別のfileを読み込み使用することが可能ということです。
- @yeild
  - 継承は、できずデフォルト値の設定が可能です。なので今回は、テンプレートになるfileのみに使用し引数として中には、`'content'`と記入することによって次に説明するsectionのfileを読み込み表示することが可能です。
- @section
  - 
