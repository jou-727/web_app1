<?php
    date_default_timezone_set('Asia/Tokyo'); // Set timezone to Japan Standard Time

    $year = date("Y");
    $month = date("m");
    $day = date("d");
    $hour = date("H");
    $minute = date("i");
    $second = date("s");

    print("現在は");
    print("$year");
    print("年");
    print("$month");
    print("月");
    print("$day");
    print("日");
    print("$hour");
    print("時");
    print("$minute");
    print("分");
    print("$second");
    print("秒です");