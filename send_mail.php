<?php
session_start();
if(!isset($_SESSION['user'])) {
    echo "セッションが無効です。";
    header("Location: login.php");
    exit;
}

//include_once 'core/dbconnect.php';

if (isset($_POST['title']) && (isset($_POST['translate']) || isset($_POST['description']))) {
    $data = "<p>".$_POST['title']."</p>";
    $data .= "<p>".htmlspecialchars($_POST['translate'])."<p>";
    $data .= "<p>".htmlspecialchars($_POST['description'])."<p>";
}

mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = $_SESSION['email'];
$subject = "検索結果リンクの送信";
$message = "<html><body>";
$message .= $data."</body></html>";
$headers = "From: ".mb_encode_mimeheader("SMART ENGINE")."<smart-engine@yrp.xyz>";
$headers .= "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8";

if (mail($to, $subject, $message, $headers)) {
    echo "メール送信成功。";
}else {
    echo "メール送信失敗。";
}
?>