#### データの投入

- DBの設定を行います
  - まずは、DBに今回用の*database*を作成します
```shell
mysql -u root -p
passwaord:
mysql > create database todos;
```
  - コマンドを実行したあとにQuery OKと表示されたら問題ありません
  - ちゃんとできているか確認する方法として
```shell
mysql > show databases;
```
  - 上記コマンドを実行するとdatabaseの一覧が表示され、そこにtodosが表示されていれば問題ありません


- Laravel側でDBを使用するための記述を行う
  - Laravelに今回使用するDBは、XXXだよとDBの接続情報を教えてあげる必要があります
  - Laravelのプロジェクト直下に*.env*というfileがありますがこれに情報を書いていきます
  - 変更前
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
DB_DATABASE=homestead # 編集対象
DB_USERNAME=homestead # 編集対象
DB_PASSWORD=secret    # 編集対象
# 省略
```
  - 変更後
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
DB_DATABASE=todos            # 編集後
DB_USERNAME=your_name        # 編集後
DB_PASSWORD=your_password    # 編集後
# 省略
```
  - 上記のように変更することによってLaravelで先ほど作成したdatabaeseが使用可能になります


- 次にtableの内容をコードとして書くことをしていきます
  - 今回はマイグレーションというバージョンのような管理機能を使ってテーブルを作成します。
  - マイグレーションファイル自体が管理機能を有しているわけでなくマイグレーションという機能がバージョンのような管理機能として働いていると考えてください。
  - 前回のアプリ作成では、MySQLに接続し直接sql文を入力し作成したかと思います
  - 今回は、migration fileというものに書き込んでいきます

```shell
php artisan make:migration create_todos_table
```

  - 上記コマンドを実行したら*database/migrations/201y_mm_dd_xxxxxx_create_todos_table.php*というfileが作成されているかなと思います
  - この作成されたfileに直接編集を行いtableの構成書き足していきます
  - では実際に編集しましょう

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

  - 上記のように編集が終わったら実際にDBに反映をします
```shell
php artisan migrate
```
  - このコマンドを実行し下記のような表示がされたら問題なくdatabasesの反映が終わったことになります
```shell
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
Migrating: 201y_mm_dd_xxxxxx_create_todos_table
Migrated:  201y_mm_dd_xxxxxx_create_todos_table
```

  - 次に初期データの投入を行います
    - seederという機能を使用してdatabaseに初期データを投入していきます
    - 今回作成したTableがTodosなのでTableは統一します
```shell
php artisan make:seeder make:seeder TodosTableSeeder
```
    - 上記コマンド実行することによって*database/seeds/*以下に作成されます
    - 変更前
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
        //
    }
}
```
   - fileが上記のような状態かと思います
   - このfileに対して編集を行なっていきます
   - 変更後
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
    }
}

```
  - 上記のように変更が終わったらこの新たに追加したClassを使用するために同じ階層に存在する。*DatabaseSeeder.php*というfileの変更を行います
  - 変更前
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
    }
}
```
  - *function run*の中がコメントアウトされている状態かと思います
  - この*function run*の中に先ほど変更を加えた*Class*を書いてあげます
  そうすることによって作成したSeederを実行しデータの投入が可能になります
  - 早速変更を加えます
  - 変更後
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
  - 変更が完了したら作成したfileをDBに反映させるためのコマンドを実行します
```shell
php artisan db:seed
Seeding: TodosTableSeeder
```
  - 上記のような表記がされたら問題なくDBに反映が行われています


- おまけ
```shell
php artisan migrate
```
  - を実行した際にもseedを行い余計なコマンドを打ちたくないなという場合
```shell
php artisan migrate --seed
```
  - を実行することによりmigration fileの実行とseed fileの実行を同時に行うことが可能になります
  
