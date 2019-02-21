<?php
require __DIR__ . "/assets/config.php";
require __DIR__ . "/../vendor/autoload.php";

use RobsonVLeite\CafeApi\Me;

$me = new Me(
    "localhost/fsphp/cafeapi/",
    "robsonvleite@gmail.com",
    "12345678"
);

/**
 * me
 */
echo "<h1>ME</h1>";

$user = $me->me();
var_dump($user->response());

/**
 * update
 */
echo "<h1>UPDATE</h1>";

$update = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

if ($update && !empty($update["user"])) {
    $user->update($update);

    if ($user->error()) {
        echo "<p class='error'>{$user->error()->message}</p>";
    } else {
        var_dump($user->response()->user);
    }
}

$userData = $user->me()->response()->user;
?>
    <form action="" method="post">
        <input type="hidden" name="user" value="true"/>
        <input type="text" name="first_name" value="<?= ($userData->first_name ?? null); ?>"/>
        <input type="text" name="last_name" value="<?= ($userData->last_name ?? null); ?>"/>
        <input type="text" name="genre" value="<?= ($userData->genre ?? null); ?>"/>
        <input type="text" name="datebirth" value="<?= ($userData->datebirth ?? null); ?>"/>
        <input type="text" name="document" value="<?= ($userData->document ?? null); ?>"/>
        <button>Atualizar</button>
    </form>
<?php

/**
 * PHOTO
 */
echo "<h1>PHOTO</h1>";

$photo = ($_FILES["photo"] ?? null);

if ($photo) {
    $user->photo($photo);

    if ($user->error()) {
        echo "<p class='error'>{$user->error()->message}</p>";
    } else {
        var_dump($user->me()->response()->user->photo);
    }
}
?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="photo"/>
        <button>Atualizar</button>
    </form>
<?php

