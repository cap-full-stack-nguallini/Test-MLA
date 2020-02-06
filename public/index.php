<?php

$sellerId = 179571326;

$dsn = "mysql:host=127.0.0.1;dbname=mla;port=3306";
$username = "root";
$password = "";
$opcional = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

try {
    $db = new PDO($dsn, $username, $password, $opcional);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e) {
    echo "No se pudo conectar a la Base de Datos";
    exit;
}

$sql = "SELECT sellers.seller_id AS seller_id, items.id AS id, items.title AS title, categories.category_id AS category_id, categories.name AS name
FROM sellers 
INNER JOIN items ON sellers.seller_id = items.seller_id
INNER JOIN categories ON items.category_id = categories.category_id
WHERE sellers.seller_id = :sellerId";

$stmt = $db->prepare($sql);

$stmt->bindParam(':sellerId', $sellerId);

$stmt->execute();

$itemsPublicados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investigación/Script</title>
</head>

<body>
    <h1>Items Publicados por el seller_id <?= $sellerId ?></h1>
    <br>
    <table cellpadding="10" border="2">
        <tr>
            <th>seller_id</th>
            <th>id del item</th>
            <th>title del item</th>
            <th>category_id</th>
            <th>name de la categoría</th>
        </tr>
        <?php foreach ($itemsPublicados as $itemPublicado) : ?>
            <tr>
                <td><?= $itemPublicado["seller_id"] ?></td>
                <td><?= $itemPublicado["id"] ?></td>
                <td><?= $itemPublicado["title"] ?></td>
                <td><?= $itemPublicado["category_id"] ?></td>
                <td><?= $itemPublicado["name"] ?></td>
            </tr>
        <?php endforeach ?>
    </table>

</body>

</html>