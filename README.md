# Query

Simples biblioteca PHP com a função de auxiliar nas execuções de Query's SQL.

Projeto foi criado ainda em 2012 com a intenção de facilitar consultas MYSQL com PHP 5.3. 

Agora, em 2021, foi atualizado com funções ORM e etc.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Punk\Query\Sql;

// open the PDO connection and set it || Abrindo conexão com PDO
Sql::setConnection(['driver' => 'mysql',
    'database' => 'database',
    'port' => 'port',
    'username' => 'username',
    'password' => 'password']);

// Connect to an users table || Conectando a tabela de usuários
$users = Sql::from("users");

// listing the users || listando os usuários
foreach ($users->runSelect() as $user) {
    echo $user['full_name'];
}

// listing some users || listando alguns usuários
foreach ($users->where(['enable' , true])->runSelect() as $user) {
    echo $user['full_name'];
}

// listing some users || listando alguns usuários
foreach ($users->where(['enable' , true])->runSelect() as $user) {
    echo $user['full_name'];
}

// diplay Query constructor user join permissions
$users->leftJoin('permissions')->limit(12)->runSelect();

// Union Query
$users->where(['enable' , true])->union($users->where(['enable' , false]));

// Subselect activities to users
$activities = Sql::from("users_activities")->select('count(id)')->where(['user_id', 'id']);
$users->leftJoin('permissions')->select($activities);
?>
```
