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

