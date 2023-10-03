<?php

$filename = 'data.txt';
$data = [];
for ($i = 0; $i < 1000; $i++) {
    $itemId = rand(1, 35);
    $customerId = rand(1, 55);
    $comment = 'Комментарий ' . ($i + 1);
    $status = ['new', 'complete'][(rand(0, 1))];
    $date = '2023-09-' . rand(1, 30);

    $data[] = $itemId
        . delimiter() . $customerId
        . delimiter() . $comment
        . delimiter() . $status
        . delimiter() . $date;
}
$data = join("\n", $data);
file_put_contents($filename, $data);
function delimiter(): string
{
    return [';', ';', ';', ';', ';', ':'][rand(0, 5)];
}

$dbh = new PDO('mysql:host=mysql;dbname=sdt', 'sdt', 'sdt');

$dbh->query('SET FOREIGN_KEY_CHECKS=0');
$dbh->query('TRUNCATE TABLE merchandise');
$dbh->query('TRUNCATE TABLE orders');
$dbh->query('TRUNCATE TABLE clients');
$dbh->query('SET FOREIGN_KEY_CHECKS=1');

for ($i = 1; $i <= 30; $i++) {
    $dbh->query("INSERT INTO clients SET name='Customer $i'");
}

for ($i = 1; $i <= 50; $i++) {
    $price = rand(100, 1000);
    $dbh->query("INSERT INTO merchandise SET name='Product $i', price=$price");
}
