## 下書き

- 短いPHPの実装経験の上で必要だと感じた最低限のコーディングルール
- 厳密な型指定
- PHPDocsの記載
- DI
- レイヤードアーキテクチャ
- 1fileでの責務の明確化
- 1メソッドの記述量

```php
<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;

/**
* class UserSetting
*/
class UserSetting
{
    /**
    * @var User
    */
    private $user;

    /**
    * constructor
    * @param User $user
    */
    public function __constructor(User $user)
    {
        $this->user = $user;
    }
}
```

- if文

```php
$item = null;
if (is_null($item)) {
    return ['message' => 'model not found'];
}

```