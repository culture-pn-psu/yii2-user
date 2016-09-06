# yii2-user

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require andatech/yii2-user "dev-master"
```

or add

```
"andatech/yii2-user": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

Config
```php
    'modules' => [
        ...
        'user' => [ //module id = 'user' only
            'class' => 'anda\user\Module',
            'loginBy' => 'db', //db or ldap
            'userUploadDir' => '@uploads', //real path
            'userUploadUrl' => '/uploads', //url path
            'userUploadPath' => 'user', //path after upload directory
            'admins' => ['admin', 'root'] //list username for manage users
        ],
        ...
    ],
```

Migration table user and profile
```html
./yii migrate --migrationPath=@anda/user/migrations/
```

# List of available actions

- **/user/regist/signup**                 Displays registration form
- **/user/auth/login**                    Displays login form
- **/user/auth/logout**                   Logs the user out (available only via POST method)
- **/user/auth/request-password-reset**   Displays request password reset form
- **/user/auth/reset-password**           Displays reset password form
- **/user/settings/profile**              Displays profile settings form
- **/user/settings/account**              Displays account settings form
- **/user/settings/change-password**      Displays change password settings form
- **/user/admin/index**                   Displays user management interface

## Example of menu

You can add links to registration, login and logout as follows:

```php
Yii::$app->user->isGuest ?
    ['label' => 'Sign in', 'url' => ['/user/auth/login']] :
    ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
        'url' => ['/user/auth/logout'],
        'linkOptions' => ['data-method' => 'post']],
['label' => 'Register', 'url' => ['/user/regist/signup'], 'visible' => Yii::$app->user->isGuest]
```

## Call user information

```php
//Current user
$user = Yii::$app->user->identity;
print_r($user->profile->resultInfo);
//if use $user->profile->resultData in result = base user data
```

Example Result
```html
stdClass Object
(
    [id] => 1
    [username] => admin
    [email] => admin@andatech.net
    [created_at] => 1473135990
    [updated_at] => 1473135990
    [firstname] => Admin
    [lastname] => สูงสุด
    [fullname] => Admin สูงสุด
    [avatar] => /uploads/user/avatars/57ce45f61e617_57ce45f60fb8b.jpg
    [cover] => /assets/37f5d0d0/images/default-cover.jpg
    [bio] =>
    [data] => Not set
    [roles] => Array
        (
        )

)
```

```php
//another user
$user = \anda\user\models\User::findOne(2);
print_r($user->profile->resultInfo);
//if use $user->profile->resultData in result = base user data
```

Example Result
```html
stdClass Object
(
    [id] => 2
    [username] => surakit.c
    [email] => surakit.c@psu.ac.th
    [created_at] => 1473136616
    [updated_at] => 1473136616
    [firstname] => สุรกิจ
    [lastname] => ชูเดช
    [fullname] => สุรกิจ ชูเดช
    [avatar] => /uploads/user/avatars/57ce4a3126b31_57ce4a31218d0.jpg
    [cover] => /uploads/user/covers/57ce4a5bd842f_57ce4a5bd40bd.png
    [bio] =>
    [data] => Not set
    [roles] => Array
        (
        )

)
```
