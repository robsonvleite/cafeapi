<?php
require __DIR__ . "/assets/config.php";
require __DIR__ . "/../vendor/autoload.php";

use RobsonVLeite\CafeApi\Invoices;

$invoices = new Invoices(
    "localhost/fsphp/cafeapi/",
    "seuemail@gmail.com",
    "12345678"
);

/**
 * index
 */
echo "<h1>INDEX</h1>";

$index = $invoices->index(null);
$index = $invoices->index([
    "wallet_id" => 23,
    "type" => "fixed_income",
    "status" => "paid",
    "page" => 2
]);

if ($index->error()) {
    echo "<p class='error'>{$index->error()->message}</p>";
} else {
    foreach ($index->response()->invoices as $invoice) {
        echo "<p>{$invoice->description} {$invoice->value}</p>";
    }

    var_dump(
        [
            "results" => $index->response()->results,
            "page" => $index->response()->page,
            "pages" => $index->response()->pages,
        ],
        $index->response()->invoices
    );
}

/**
 * create
 */
echo "<h1>CREATE</h1>";

$create = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
if ($create && !empty($create["create"])) {
    $invoiceCreate = $invoices->create($create);

    if ($invoiceCreate->error()) {
        echo "<p class='error'>{$invoiceCreate->error()->message}</p>";
    } else {
        $create = null;
        var_dump($invoiceCreate->response()->invoice);
    }
} else {
    $create = null;
}

$value = function ($value) use ($create) {
    return (!empty($create[$value]) ? $create[$value] : null);
};

?>
    <form action="" method="post">
        <input type="hidden" name="create" value="true"/>
        <input type="text" name="wallet_id" value="<?= $value("wallet_id"); ?>" placeholder="wallet_id | Ex: 23"/>
        <input type="text" name="category_id" value="<?= $value("category_id"); ?>" placeholder="category_id | Ex: 3"/>
        <input type="text" name="description" value="<?= $value("description"); ?>"
               placeholder="description | Ex: By Component"/>
        <input type="text" name="type" value="<?= $value("type"); ?>" placeholder="type | Ex: income"/>
        <input type="text" name="value" value="<?= $value("value"); ?>" placeholder="value | Ex: 2500.10"/>
        <input type="text" name="due_at" value="<?= $value("due_at"); ?>" placeholder="due_at | Ex: 2019-02-20"/>
        <input type="text" name="repeat_when" value="<?= $value("repeat_when"); ?>"
               placeholder="repeat_when | Ex: single"/>
        <input type="text" name="period" value="<?= $value("period"); ?>" placeholder="period | Ex: month"/>
        <input type="text" name="enrollments" value="<?= $value("enrollments"); ?>" placeholder="enrollments | Ex: 1"/>
        <button>Cadastrar</button>
    </form>
<?php

/**
 * READ
 */
echo "<h1>READ</h1>";

$invoice = $invoices->read(855);
$invoice = $invoices->read(91);

if ($invoice->error()) {
    echo "<p class='error'>{$invoice->error()->message}</p>";
} else {
    $invoiceData = $invoice->response()->invoice;
    var_dump(
        $invoiceData,
        $invoiceData->wallet
    );
}

/**
 * UPDATE
 */
echo "<h1>UPDATE</h1>";

$invoiceId = 91;
$invoiceUpdate = $invoices->read($invoiceId);

if ($invoiceUpdate->error()) {
    echo "<p class='error'>{$invoiceUpdate->error()->message}</p>";
} else {
    $update = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

    if ($update && !empty($update["update"])) {
        $invoiceUpdate->update($invoiceId, $update);

        if ($invoiceUpdate->error()) {
            echo "<p class='error'>{$invoiceUpdate->error()->message}</p>";
        } else {
            var_dump($invoiceUpdate->response()->invoice);
        }
    } else {
        $update = null;
    }

    $data = $invoiceUpdate->read($invoiceId)->response()->invoice;
    $value = function ($value) use ($data) {
        return (!empty($data->$value) ? $data->$value : null);
    };
    ?>

    <form action="" method="post">
        <input type="hidden" name="update" value="true"/>
        <input type="text" name="wallet_id" value="<?= $value("wallet_id"); ?>"/>
        <input type="text" name="category_id" value="<?= $value("category_id"); ?>"/>
        <input type="text" name="description" value="<?= $value("description"); ?>"/>
        <input type="text" name="value" value="<?= $value("value"); ?>"/>
        <input type="text" name="due_day" value="<?= date("d", strtotime($value("due_at"))); ?>"/>
        <input type="text" name="status" value="<?= $value("status"); ?>"/>
        <button>Atualizar</button>
    </form>
    <?php
}

/**
 * DELETE
 */
echo "<h1>DELETE</h1>";

$delete = $invoices->delete(91);
if ($delete->error()) {
    echo "<p class='error'>{$delete->error()->message}</p>";
} else {
    echo "<p>Lançamento foi excluído com sucesso!</p>";
}