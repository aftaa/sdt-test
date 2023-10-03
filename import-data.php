<?php

$dbh = new PDO('mysql:host=mysql;dbname=sdt', 'sdt', 'sdt');
$filename = 'data.txt';
$wrong_filename = 'data-wrong.txt';
$f = fopen($filename, 'r');
$w = fopen($wrong_filename, 'w');

while (false !== ($s = fgets($f))) {
    $pcre = '/^(\d+);(\d+);([^;]+);(new|complete);(\d{4}-\d{2}-\d{1,2})\n$/';
    if (preg_match($pcre, $s, $matches)) { // строка из файла подходит под формат $pcre
        [, $itemId, $clientId, $comment, $status, $date] = $matches;

        // подготавливаем запрос
        $sql = 'INSERT INTO orders SET item_id=?,customer_id=?,comment=?,status=?,order_date=?';
        $sth = $dbh->prepare($sql);

        try {
            // выполняем запрос в транзакции
            $dbh->beginTransaction();
            $sth->execute([$itemId, $clientId, $comment, $status, $date]);
            $dbh->commit();
        } catch (PDOException $e) {
            // запрос нарушает целостность БД, т.е. неверный item_id или customer_id
            $dbh->rollBack();
            // пишем неправильную строку данных в файл
            fwrite($w, $s);
        }
    } else {
        // пишем неправильную строку данных в файл
        fwrite($w, $s);
    }
}
