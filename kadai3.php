<?php
try {
        $db = new PDO('mysql:dbname=mydb;host=localhost;port=8888;charset=utf8', 'root', 'root');
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
    ?>
<!DOCTYPE html>
<html lang="ja">
    <body>
        <table border="1">
        <tr>
            <th>名前</th>
            <th>個数</th>
        </tr>
        <tr>
            <td><?php echo $db; ?></td>
            <td>25</td>
        </tr>
        <tr>
            <td>佐藤花子</td>
            <td>30</td>
        </tr>
    </body>
</html>