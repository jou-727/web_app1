<?php
    session_start();

    print("セッションに保存された名前は");
    print($_SESSION['name']);
    print("です<br>");