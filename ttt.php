<?php
try {
  $pdo = new PDO("mysql:host=localhost;dbname=click_game;charset=utf8mb4", "root", "ここにパスワード");
  echo "✅ 接続成功！";
} catch (PDOException $e) {
  echo "❌ 接続エラー: " . $e->getMessage();
}
