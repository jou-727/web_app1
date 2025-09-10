<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['user'];
$clicks = isset($_POST['clicks']) ? intval($_POST['clicks']) : 0;
$duration = 3;
$rate = $clicks / $duration;

$host = 'localhost';
$dbname = 'click_game';
$user = 'admin';
$pass = 'admin';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // そのユーザーのハイスコアを取得
  $stmt = $pdo->prepare("SELECT MAX(rate) FROM scores WHERE username = ?");
  $stmt->execute([$username]);
  $currentHigh = $stmt->fetchColumn();

  if (!$currentHigh || $rate > $currentHigh) {
    // ハイスコア更新（INSERT）
    $stmt = $pdo->prepare("INSERT INTO scores (username, clicks, rate) VALUES (?, ?, ?)");
    $stmt->execute([$username, $clicks, $rate]);
    $message = "🎉 ハイスコア更新！おめでとうございます！";
  } else {
    $message = "👍 今回のスコアは記録されませんでした（ハイスコア未満）";
  }

} catch (PDOException $e) {
  die("DBエラー: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>結果発表</title>
  <style>
    body { font-family: sans-serif; text-align: center; margin-top: 60px; }
    .result { font-size: 20px; margin-top: 20px; }
    .highlight { font-weight: bold; color: #d32f2f; }
  </style>
</head>
<body>
  <h1>結果発表</h1>
  <p>ユーザー名：<strong><?= htmlspecialchars($username) ?></strong></p>
  <p>クリック数：<strong><?= $clicks ?></strong></p>
  <p>秒間クリック数：<strong><?= round($rate, 2) ?></strong></p>
  <div class="result"><?= $message ?></div>
  <p><a href="s_index.php">もう一度挑戦する</a></p>
</body>
</html>
<!-- スコアボード表示 -->
<h2>🏆 スコアボード（上位10名）</h2>
<table style="margin: auto; border-collapse: collapse; width: 80%;">
  <thead>
    <tr style="background-color: #fbc02d;">
      <th style="padding: 8px; border: 1px solid #ccc;">順位</th>
      <th style="padding: 8px; border: 1px solid #ccc;">ユーザー名</th>
      <th style="padding: 8px; border: 1px solid #ccc;">クリック数</th>
      <th style="padding: 8px; border: 1px solid #ccc;">秒間クリック数</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // ユーザーごとの最高スコアを取得（サブクエリで最大rateを抽出）
    $stmt = $pdo->query("
      SELECT username, clicks, rate
      FROM scores
      WHERE (username, rate) IN (
        SELECT username, MAX(rate)
        FROM scores
        GROUP BY username
      )
      ORDER BY rate DESC
      LIMIT 10
    ");

    $rank = 1;
    foreach ($stmt as $row) {
      echo "<tr>";
      echo "<td style='padding: 8px; border: 1px solid #ccc;'>{$rank}</td>";
      echo "<td style='padding: 8px; border: 1px solid #ccc;'>" . htmlspecialchars($row['username']) . "</td>";
      echo "<td style='padding: 8px; border: 1px solid #ccc;'>{$row['clicks']}</td>";
      echo "<td style='padding: 8px; border: 1px solid #ccc;'>" . round($row['rate'], 2) . "</td>";
      echo "</tr>";
      $rank++;
    }
    ?>
  </tbody>
</table>
