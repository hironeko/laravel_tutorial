# Controllerを仕上げていく

- Viewに関しては、概ね完了してます。それに対応した `Controller` の記述を書いていきます。
- 現状として書かれているのは、`index` メソッドのみかと思います。なので `create` 、 `edit` 、 `destroy` に付随するメソッドを含め記載を行い、DBへの値の保存などの操作を行えるようにします。

まず最初に `DB` への操作が行えるように `Model` のfileを作成します
```shell
phpp artisan make:model Todo
```
`app/` 以下に下記のようなfileが作成されましたでしょうか？
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
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
最初は、`index` メソッドに対してです。

```php
// 上記省略
    public function index()
    {
        $todos = $this->todo->all();
        return view('todo.index', compact('todos'));
    }
// 以下省略
```
