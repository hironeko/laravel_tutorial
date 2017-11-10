# Controllerの作成

アプリケーションの要となる*Controller*が必要なので作成を行います。以下のコマンドを実行してください。

```shell
php artisan make:controller TodoController --resource
```

作成が完了したら*app/Http/Controllers*内に存在する*TodoController.php*を確認してください。
以下のような中身になっているかと思います。

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
```

色々なメソッドの記載があります。
phpでは、classに属する関数をメソッドと呼びます。では、プログラミングの世界の慣習として*Hello word*という文言を出力させてみましょう。


```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "Hello world!!";
    }
// 以下省略
```

## 表示させるためにルーティング機能に手を加えます。
Controllerの編集が終わりましたら次にこのControllerを動かすためにルーティング機能に対して手を加えます。
開くfileは、*route*フォルダ以下にある。*web.php*を開きます。中身は、以下のようになってます。
  
```php
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('todo', 'TodoController');  // 追記
```

では、作成したものが反映されているか確認するためにLaravelのローカルサーバを立ち上げましょう。

```shell
php artisan serve
```

ブラウザに*http://127.0.0.1:8000/todo* と入れてアクセスしてください。
画面に"Hello world!!"と表示されたなら問題ありません。
これでcontrollerとroute fileの関連性がイメージできたかと思います。
※追って細かな説明していきますので安心してください。
