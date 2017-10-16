# Controllerを仕上げていく

- Viewに関しては、概ね完了してます。それに対応した `Controller` の記述を書いていきます。
- 現状として書かれているのは、`index` メソッドのみかと思います。なので `create` 、 `edit` 、 `destroy` に付随するメソッドを含め記載を行い、DBへの値の保存などの操作を行えるようにします。

まず最初に `DB` への操作が行えるように `Model` のfileを作成します
```shell
phpp artisan make:model Todo
```
`app/` 以下にfileが作成されたと思うので編集を行います。

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title']; // 追記
}
```

この作成したfileを `Controller` 側で使用できるようにします。この `Model` を継承したfileというのが `DB` への操作を可能にするfileとなります。

編集file `app/Http/Controllers/TodoController.php` を編集します。
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;  // 追記

class TodoController extends Controller
{
    // ここから追記
    private $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }
    // ここまで追記
// 以下省略
```

これだけで `model` の使用が可能になります。順を追って説明していきましょう。
- `use AppApp\Todo;` ： 最初のうちは、`require()` メソッドに近いイメージをしていただけたらいいと思います。この記述をすることによって `app/Todo.php` を使用することができます。 `use` は、日本語で使うという意味、それ以下に書かれているのは、fileまでのパスが書いてあると思ってください。

- `private $todo;` ：privateは、日本的にクローズドなイメージを抱くかと思います。この場合の用途としてもまさにそのままでこれは、 `Class` 内でしか使用しない変数言い換えれば `このClass` 以外からのアクセスを避けたい変数の定義のさいに使用されます。
  - 他にも、`public` `protected` と種類がありますので比べてみてみるのもいいかと思います。

- `__construct` ：このメソッドなのですが `マジックメソッド` と呼ばれたりします。基本的な用途としてこの `Class` が使用される際 = `Classのインスタンス化` が行われた際に設定しておきたい値などを設定するメソッドとして使われます。これを初期化とか初期値設定などと読んだりします。
  - 引数の箇所で `use` をした `app/Todo` を `Todo` という形で使用してます。実態は、`Todo Class` のインスタンス化です。なのでそれを引数として受け取りかつ変数に代入します。その際注意が必要なのが`private $todo;`とは、別物だということです。
  - メソッドの中で `$this->todo` という風に書いたものに引数で渡ってきたものを代入してます。これは、`private $todo;` へアクセスし代入を行なっていることになります。 `$this->todo` の `$this` が自身(Class)自体をさしているのでその中に存在する `$todo` を意味しています。なぜ `->` という書き方をしたのかというとオブジェクトに対して操作をする際は、必ずこの書き方を行う必要があります。以後覚えておきましょう。

作成したViewを使用するための記述を順次書いていきます。ここまでは、あくまでの下準備に過ぎないので各メソッドに対して追記を行なっていきます。

## `index` メソッドの編集

```php
// 上記省略
    public function index()
    {
        $todos = $this->todo->all();  // 追記
        return view('todo.index', compact('todos'));  // 編集
    }
// 以下省略
```

modelは、DBへの操作を行うものと言いました。ここで `$this->todo->all()` と書かれておりそれは、 `$todos` へ代入されています。ここでわかるのは、代入された変数は、複数形になっているので1個以上の値が入ってきているのだということがわかります。
実際に何をしているか？答えは、簡単で `$this->todo->all()` とすることでDBのから全件取得してます。つまり `SELECT * FORM Todos;` というSQL文が発行されてます。

どのFWでも大抵は、DB操作を楽するためのツールをあらかじめ導入しておりそれを用いて簡潔にかつソースでDBへの操作を実現してます。このようなものを `ORM` と言います。
DBからの返却データは、Objectとしてデータが返却されます。この返却されたObjectをViewに渡し取得した値を表示したりしてます。そのためには、取得したデータをViewに渡さなければなりません。そのための記述として `return view('todo.index', compact('todos'));` という書き方をしています。この `compact` というのは、日本語でぎっしり詰めてという意味になるので `compact()` にview側に渡したい変数を記述してあげます。そうすることによってview側で変数を使用することが可能となります。

後ほどViewの方を再度修正したいと思います。

## `Create` メソッドの編集

処理という処理はないですがViewの表示が行えるように編集を行います。

```php
// 省略
    public function create()
    {
        return view('todo.create');  // 追記
    }
// 以下省略
```

View fileの指定を行います。Createメソッドに関しては、以上となります。


## `Store` メソッドの編集

このメソッドがどんな役割をするメソッドかどうかからの説明が必要になると思います。まず最初に `Store` というのは、英語では多義語となってます。今回の使い道としては、格納というイメージでの使われ方をしていると思います。

格納という意味を知って即座にDBを連想した方は、素晴らしいです。DBにデータを格納するための処理を行うメソッドになっています。

```php
// 省略
    public function store(Request $request)
    {
        // 以下 returnまで追記
        $input = $request->all();
        $this->todo->fill($input)->save();
        return redirect->to('todo');
    }
```
 
見たことないものばかりかと思います。
- `Request $request` ：fileの上部に記載ある `ues Illuminate\Http\Request;` の `Request` を使用してます。これを使うことで何が実現できているかというと`Form` タグで送信した `POST` 情報を取得することを実現してます。

- `$this->todo->fill($input)->save();` ：fillは、引数を設定できるかどうかを確認してくれます。これは、`Model file` に追記した記述をしていることによって可能としてます。かつ最後の `save()` でデータの保存を行います。※指定外のものは無視します。

最後に保存完了後は、一覧画面に遷移させる記述を行なっています。

## `Edit` メソッドを編集

- このメソッドを通してTodoの更新を行います。

```php
    public function edit($id)
    {
        $todo = $this->todo->find($id);  // 追記
        return view('todo.edit', compact('todo'));  // 追記
    }
```

今回は、あまり説明するような箇所はないのですが2箇所だけ説明をいたします。
- `edit($id)` ：これは、`URL` のパラメータの取得のための記述になります。`php artisan route:list` で `route` の一覧を確認してみてください。そうすると `todo/{todo}/edit` となっているはずです。この `{edit}` の箇所がパラメータ扱いになります。view側で引数で渡すことによって画面遷移用のURLが作成できるようになっています。このControllerの記述が終わったら再度Viewの仕上げを行います。その際に再度説明を交えます。

- `$this->todo->find($id);` ：パラメータで渡ってきた値を元にDBへ検索を行なっています。これにより指定のデータのみ取得することが可能になり、編集画面に一覧で選択したTitileのものを表示し更新を可能にします。
