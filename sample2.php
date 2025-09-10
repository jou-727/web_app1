<?php
    $apple = 100;
    $meet = 1000;
    $egg = 200;
    print("税抜きの合計金額は");
    print($apple*2 + $meet + $egg*2);
    print("円です<br>");
    print("税込みの合計金額は");
    print($apple*2*1.1 + $meet*1.1 + $egg*2*1.1);
    print("円です");