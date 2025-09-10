<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
    echo "名前: " . $name . "<br>";
}
?>