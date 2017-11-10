# データの投入

## DBの設定を行います。
まずは、DBに今回用の*database*を作成します。

```shell
mysql -u root -p
passwaord:
mysql > create database todos;
```

コマンドを実行したあとにQuery OKと表示されたら問題ありません。
作成されたかどうか確認するには、以下のコマンドを実行したら確認できます。

```shell
mysql > show databases;
```
上記コマンドを実行するとdatabaseの一覧が表示され、そこにtodosが表示されていれば問題ありません


## Laravel側でDBを使用するための記述を行う
- Laravelに今回使用するDBは、XXXだよとDBの接続情報を教えてあげる必要があります
- Laravelのプロジェクト直下に*.env*というfileがありますがこれに情報を書いていきます

```shell
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:Rs6WHziGChaNJGg0o1mBOidiKaFZPkKeHNt6aGamvYk=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todos            # 編集
DB_USERNAME=your_name        # 編集 DBを作成した際のUser名
DB_PASSWORD=your_password    # 編集 DBを作成した際のUserのPassword
# 省略
```

上記のように変更することによってLaravelで先ほど作成したdatabaeseが使用可能になります。


## 次にtableの内容をコードとして書くことをしていきます
今回はマイグレーションというバージョンのような管理機能を使ってテーブルを作成します。
  - マイグレーションファイル自体が管理機能を有しているわけでなくマイグレーションという機能がバージョンのような管理機能として働いていると考えてください。
  - 前回のアプリ作成では、MySQLに接続し直接sql文を入力し作成したかと思います。
  - 今回は、migration fileというものに書き込んでいきます。

fileの作成を行うコマンド
```shell
php artisan make:migration create_todos_table
```

上記コマンドを実行したら*database/migrations/201y_mm_dd_xxxxxx_create_todos_table.php*というfileが作成されていると思います。
この作成されたfileの編集を行いtableの構成を書いていきます。

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');  /* 追加 */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
```

上記のように編集が終わったら実際にDBに反映をします。

```shell
php artisan migrate
```

このコマンドを実行し下記のような表示がされたら問題なくdatabasesの反映が終わったことになります。

```shell
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
Migrating: 201y_mm_dd_xxxxxx_create_todos_table
Migrated:  201y_mm_dd_xxxxxx_create_todos_table
```

## DBに初期データの投入を行います
- seederという機能を使用してdatabaseに初期データを投入するためのfileの作成と記述を行います。

```shell
php artisan make:seeder TodosTableSeeder
```

上記コマンド実行することによって*database/seeds/*以下に作成されます。
作成されたfileに対して編集を行います。以下に記載あるように追加と記載ある範囲を写経しましょう。


```php
<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ここから追記
        DB::table('todos')->truncate();

        DB::table('todos')->insert([
            [
                'title'      => 'フレームワークカリキュラムを終わらせる',
                'created_at' => '2018-01-01 23:59:59',
                'updated_at' => '2018-01-04 23:59:59',
            ],
            [
                'title'      => 'Unixオペレーションに慣れる',
                'created_at' => '2018-02-01 00:00:00',
                'updated_at' => '2018-02-05 00:00:00',
            ],
        ]);
        
        // ここまで追記
    }
}
```

上記のように変更が終わったらこの新たに追加したClassを使用するために同じ階層に存在する。*DatabaseSeeder.php*というfileに追記を行います。
*run*というメソッドの中に先ほど手を加えた*Class*のClass名を書いてあげます。
そうすることによって作成したSeederを実行しデータの投入が可能になります。

```php
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TodosTableSeeder::class); // 追加
    }
}
```
## DBに反映させる
変更が完了したら作成したfileをDBに反映させるためのコマンドを実行します。

```shell
php artisan db:seed
Seeding: TodosTableSeeder
```

コマンド実行後に上記のような表記がされたら問題なくDBに反映が行われています。

## おまけ

```shell
php artisan migrate
php artisan db:seed
# 以下と同義です
php artisan migrate --seed
```
実行することにより結果migration fileの実行とseed fileの実行を同時に行うことが可能になります。 
