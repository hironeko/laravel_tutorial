# PHPUnitの実装

- Laravelに最初から付随しているPHPUnitを使用します。

## 早速実行してみましょう

Laravelが存在しているディレクトリにて以下のコマンドを実行してみてください。

```shell
./vendor/bin/phpunit
PHPUnit 6.4.4 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 122 ms, Memory: 12.00MB

OK (2 tests, 2 assertions)
```

という結果になりましたでしょうか？
これを一つずつ解説していきます。こちらは、テストの実行結果になってます。
ではどこをテストしどこにそのテストのコードが記載されているのかそれらを含め少しずつ追っていきたいと思います。

### テストのコードはどこに？

`tests/Feature/ExampleTest.php`
`tests/Unit/ExampleTest.php`
です。

Laravelに付属しているPHPUnitを使用してのテストを書く場合は、上記の場所に格納します。またそれぞれ意味があるのでそれらも一緒に把握をしていきましょう。

- `Feature`

これは、日本語的には、「特徴・特性」といった意味になりますがプログラマーとしての意味は、「機能」と訳した方がしっくりくるかもしれません。
また近しい言葉に`function` がありますがこちらは、より技術的な側面を持っているものになっております。

ここに格納されるテストコードは、広義の意味での機能テストとなります。
実際に中を覗くとわかると思いますがどの`URI` に対してのレクエストを送りその結果どうなったかをテストする内容になってます。

- `Unit`

日本語的には、「単位」といった意味になります。
どんな時に使うのか？を知った際にとてもしっくりくるかと思います。
テスト対象は、最小単位のコードです。

> 中身は、後ほど一緒に見ていきましょう。

- まとめ

上記踏まえ`Feature` で広義にテストコードを書き`Unit` に対して最小単位のメソッドないし機能に対してのテストを書くことによって結合テストの時間を減らせることが容易に想像できます。

また結合テストというのは、前章で述べたようにブラウザにて人力にデータの入力等を行い期待通りの結果になるかどうかのテストをここでは指しています。

なのでこのカリキュラムでは、まず最初に`Feature` にてリクエスト関連のテストを行い、`Unit` にて機能レベルのテストを行なっていきたいと思います。


### テストコードを読んでみる

- では、早速テストのコードを見ていきましょう。

`tests/Feature/ExampleTest.php` からみていきましょう。

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
```

実際にこれらは、何をテストしているのか確認していきましょう。
`extends TestCase` の箇所は、お作法だと思ってください。なので新規にテストコードを書く際も必ず記載がないとなりません。

`public function testBasicTest` の中を見ていきましょう。

PHPUnitの基本としてメソッドを書く際には、二通りの書き方が存在してます。(versionで異なる)

`test` という接頭辞から`function` を始める場合
`function` 名に`test` と含めずにアノテーションでテストコードですよと宣言する場合

この二通りが存在してます。

では、実際にアノテーションで書いて実行して見ましょう。

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     * @test  // 追記
     * @return void
     */
    public function basicTest() // 変更
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
```

変更が完了したらテストを実行しましょう。

```shell
./vendor/bin/phpunit
PHPUnit 6.4.4 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 125 ms, Memory: 12.00MB

OK (2 tests, 2 assertions)
```

問題なくテストが行えましたね。
これで2通りの書き方が学べました。
では、次に中身を見ていきましょう。

- `$response = $this->get('/');`

まず`$this->get('/')` ですがこれは、get リクエストで引数のURIにアクセスするものになります。その結果の返り値を`$response` に格納してます。
これは通常のリクエスト結果が格納されているに等しいと認識して今は、問題ありません。
その返り値に対して`$response->assertStatus(200)` という記述が書かれてます。これは、リクエスト結果のステータスを確認してます。

`assetStatus` これは、`responceのstatusには、()内の値を期待する` ということです。つまり()内の指定の数値以外は、全てが異常系という扱いになります。それは、機能としてよろしくないということになります。

なのでここでは、問題なくhttp通信でのGETリクエストが問題なく行われているかどうかのテストを行なっています。


`tests/Unit/ExampleTest.php` の中を見ていきましょう。

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
}
```

先ほどと同様にアノテーションでの書き換えも可能です。
こちらのテストに関しては、どこに対してのテストなのか？また何のテストをしているのかは、これだと読み解けないです。

ただし`true` を`false` に変えたら`FAILURES!` となります。
こちらの方では、特段何かしらに対してのテストかは、言及しませんが`assertTrue` という箇所は、覚えておきましょう。
他のテストを作成する上で使うことが想定されるメソッドになっています。



## 実践していきましょう

### `Feature` のテスト

今回作成したTodo Applicationへのテストとなります。
最初に`Feature` 側に対してのテストを実装していきたいと思います。

```shell
php artisan make:test TodoTest
```

`tests/Feature/` 以下にTodoTest.phpが作成されましたでしょうか？
作成されたFileは、以下のようになっているはずです。

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(ture);
    }
}
```

この作成されたFileの`fucntion` を編集し`TodoController` の`index` メソッドに対してテストを書きたいと思います。

```php
    /**
     * A basic test example.
     * @test  // 追記
     * @return void
     */
    public function indexTest()  // 変更
    {
    　　// 以下変更と追記
        $response = $this->get('/todo');
        $response->assertStatus(200);
    }
```

ではテストを実行して見ましょう。

```shell
./vendor/bin/phpunit tests/Feature/TodoTest.php
```

最初に実行したコマンドと異なり今回は、Fileの指定を行なっています。
こうすることにより指定したFileのみテストが実行可能になります。

では、結果はどうなりましたでしょうか？
問題なく通過したのではないでしょうか？

> もし`F`という文言があったならば`MySQL` の起動の有無を確認してください。

これで`index` メソッドに対してのテストは、行われました。
`index` メソッドにより表示されるページというのは、Todoの一覧画面となってますが実際にどんな値が渡っているかどうかは、テストしてません。

このまま他の画面に対してのテストも実装していきたいのですが今の状態でのテストの実装は、`create` メソッドまでになります。
というのもこれ以降の画面に対しての処理には、データが必要になってきますのでテストで使用する`DB` の設定を行いたいと思います。

```php
// 省略
    /** @test */
    public function createTest()
    {
        $response = $this->get('/todo/create');
        $response->assertStatus(200);
    }
}
```


## テスト用の`DB` 設定を行う

- ネット上には、いくつかの設定方法がありますが一旦は、わかりやすいもので設定を行いたいと思います。
`phpunit.xml` を編集します。

```xml
<!-- 省略 -->
  <php>
  <!-- 省略 -->
      <env name="DB_DATABASE" value="TestDBName"/> <!-- 追記 -->
  </php>
</phpunit>
```
上記のように追加してください。

次にテストが実行される際に`migrate` が走るように設定を行います。

そのために編集、追記を行うFileは、以下の2個です。
`tests/CreatesApplication.php`
`tests/TestCase.php`  

`tests/CreateApplication.php` を編集します。

```php
<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Artisan; // 追記
use App\Todo; // 追記

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    // ここから追記
    public function prepareForTests()
    {
        Artisan::call('migrate');
        if(!Todo::all()->count()){
            Artisan::call('db:seed');
        }
    }
    // ここまで追記
}
```

- 解説
`use Artisan;`
Laravelの学習をするにあたり何度も出てきた`Artisan` コマンドを使えるようにするための記述です。

`use App\Todo;`
modelに当たる`aap/Todo.php` を使用できるようにし`table` への操作を行うのが目的です。

それぞれの使い方は、`public function prepareForTests` の中をご覧ください。

編集を加えたことによって使用可能になるのかと思いきやこのままでは、使用できません。使用するには、`TestCase.php` を編集します。
では、早速編集しましょう。

```php
<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;
    
    public function setup()
    {
        parent::setup();
        $this->prepareForTests();
    }
}
```

さて編集が完了したので実際に動かしてみましょう。

```php
./vendor/bin/phpunit
```
問題なく完了したら次に`DB` の中を確認してみましょう。

テスト用の`DB` に対して`seed` まで完了できていることが確認できたら問題ありません。
