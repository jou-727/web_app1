<?php
    session_start();
    $_SESSION['name'] = '小池 壌';

    print("セッションに名前(");
    print($_SESSION['name']);
    print(")を保存しました。<br>");