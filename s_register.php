<?php
$host = 'localhost';
$dbname = 'click_game';
$user = 'admin';
$pass = 'admin'; // ← 環境に合わせて設定

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("DB接続エラー: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  if (strlen($username) < 3 || strlen($password) < 4) {
    $error = "ユーザー名は3文字以上、パスワードは4文字以上にしてください";
  } else {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
      $error = "このユーザー名はすでに使われています";
    } else {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
      $stmt->execute([$username, $hashed]);
      $success = "登録が完了しました！ログインしてください。";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー登録</title>
  <style>
    body {
      background: linear-gradient(to right, #ffe082, #ffca28);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-box {
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      width: 350px;
      text-align: center;
      animation: fadeIn 0.8s ease-in-out;
    }

    h2 {
      margin-bottom: 20px;
      color: #f57c00;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #f57c00;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #e65100;
    }

    .message {
      margin-top: 15px;
      font-weight: bold;
    }

    .message.success {
      color: green;
    }

    .message.error {
      color: red;
    }

    a {
      display: block;
      margin-top: 20px;
      color: #1976d2;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>ユーザー登録</h2>
    <?php if (isset($error)) echo "<div class='message error'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='message success'>$success</div>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="ユーザー名" required>
      <input type="password" name="password" placeholder="パスワード" required>
      <button type="submit">登録する</button>
    </form>
    <a href="s_login.php">ログイン画面へ戻る</a>
  </div>
</body>
</html>
