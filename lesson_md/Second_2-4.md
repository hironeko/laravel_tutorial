# Routeについて

前回の章まででviewのベースとなるものの作成は終わったものの画面遷移などに関しては、エラーが出るような状況になってます。

ここまでの流れと実装した内容を振り返ります。
- DBの作成とダミーデータとして使うためのデータの生成
- Laravelの動作確認
- Controllerへの記述
- Viewのベースの作成、表示の確認、Viewの分割、Formの変更
以上を行ってきました。

Formの変更を行った際に見慣れない記述が出たと思います。
特に `route` の箇所です。

まずは、 `php artisan route:list` でRouteの一覧表示を行いましょう。
以下のように表示がされましたでしょうか？

```shell
+--------|-----------|------------------|--------------|---------------------------------------------|--------------+
| Domain | Method    | URI              | Name         | Action                                      | Middleware   |
+--------|-----------|------------------|--------------|---------------------------------------------|--------------+
|        | GET|HEAD  | /                |              | Closure                                     | web          |
|        | GET|HEAD  | api/user         |              | Closure                                     | api,auth:api |
|        | GET|HEAD  | todo             | todo.index   | App\Http\Controllers\TodoController@index   | web          |
|        | POST      | todo             | todo.store   | App\Http\Controllers\TodoController@store   | web          |
|        | GET|HEAD  | todo/create      | todo.create  | App\Http\Controllers\TodoController@create  | web          |
|        | GET|HEAD  | todo/{todo}      | todo.show    | App\Http\Controllers\TodoController@show    | web          |
|        | PUT|PATCH | todo/{todo}      | todo.update  | App\Http\Controllers\TodoController@update  | web          |
|        | DELETE    | todo/{todo}      | todo.destroy | App\Http\Controllers\TodoController@destroy | web          |
|        | GET|HEAD  | todo/{todo}/edit | todo.edit    | App\Http\Controllers\TodoController@edit    | web          |
+--------|-----------|------------------|--------------|---------------------------------------------|--------------+
```

見慣れない箇所として `Name` `Action` `Middleware` かと思います。他の `Method` `URI` に関しては、イメージはつくかと思いますが `URI` という単語は、初耳かと思います。
ここでいう`URI` は、ドメイン以下要するに `127.0.0.1:8000` 以下をさしてます。なのでURLを `http://127.0.0.1:8000/todo` とすることで画面には、`TodoController` の `index` メソッドで定義したViewが表示されます(処理されます)。
- `Name` ：この `URI` を使用する際は、この `Name` を使用すれば対象 `Action` のメソッドが使用されますよ。という意味になります。
  - 使い方としては、以下のような使い方をします。
  
  ```php
  route('todo.index');
  // routeは、Laravelが用意しているものになります。
  ```
  
- `Middleware` ：使用しているMiddlewareの記載を行なってます。 `web` は必ずないし基本的には使用されると考えて問題ないです。ただ上から2個目のように `api` を別で定義している場合は、このように表示されます。※今回は、`api` の使用は行わないので今は、気にしなくて問題ありません。

