<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>高橋名人バトル</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: radial-gradient(circle, #ffecb3, #fbc02d);
      text-align: center;
      padding-top: 60px;
      color: #333;
    }

    h1 {
      font-size: 36px;
      margin-bottom: 10px;
      color: #d32f2f;
      text-shadow: 1px 1px 2px #fff;
    }

    p {
      font-size: 18px;
      margin-bottom: 20px;
    }

    #startBtn {
      padding: 12px 24px;
      font-size: 20px;
      background-color: #1976d2;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    #startBtn:hover {
      background-color: #0d47a1;
    }

    #clickBtn {
      background-color: #e53935;
      color: white;
      font-size: 24px;
      border: none;
      border-radius: 50%;
      width: 150px;
      height: 150px;
      margin-top: 30px;
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      transition: transform 0.1s ease;
    }

    #clickBtn:active {
      transform: scale(0.95);
    }

    .stats {
      font-size: 20px;
      margin-top: 20px;
    }

    #resultForm {
      display: none;
    }
    .logout-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  background-color: #d32f2f;
  color: white;
  padding: 8px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 0 5px rgba(0,0,0,0.2);
  transition: background-color 0.3s;
}

.logout-btn:hover {
  background-color: #b71c1c;
}

  </style>
</head>
<body>
  <a href="s_logout.php" class="logout-btn">ログアウト</a>
  <h1>VS 高橋名人</h1>
  <p>3秒間で何回クリックできるか挑戦しよう！</p>

  <button id="startBtn">Start</button><br>
  <button id="clickBtn" disabled>Click!</button>

  <div class="stats">
    <p>残り時間: <span id="time">3</span> 秒</p>
    <p>クリック数: <span id="count">0</span></p>
  </div>

  <form id="resultForm" action="s_result.php" method="POST">
    <input type="hidden" name="clicks" id="clicksInput">
  </form>

  <script>
    let count = 0;
    let timeLeft = 3;
    let timer;

    document.getElementById("startBtn").onclick = function() {
  count = 0;
  timeLeft = 3;
  document.getElementById("count").textContent = count;
  document.getElementById("time").textContent = "準備中…";
  document.getElementById("clickBtn").disabled = true;

  let prepTime = 3;
  const prepInterval = setInterval(() => {
    document.getElementById("time").textContent = `スタートまで: ${prepTime}`;
    prepTime--;
    if (prepTime < 0) {
      clearInterval(prepInterval);
      document.getElementById("clickBtn").disabled = false;
      document.getElementById("time").textContent = timeLeft;

      timer = setInterval(() => {
        timeLeft--;
        document.getElementById("time").textContent = timeLeft;
        if (timeLeft <= 0) {
          clearInterval(timer);
          document.getElementById("clickBtn").disabled = true;
          document.getElementById("clicksInput").value = count;
          document.getElementById("resultForm").submit();
        }
      }, 1000);
    }
  }, 1000);
};

    document.getElementById("clickBtn").onclick = function() {
      count++;
      document.getElementById("count").textContent = count;
    };
  </script>
</body>
</html>
