<?php
session_start();
if(!isset($_SESSION['user'])) {
    //echo "セッションが無効です。";
    //header("Location: login.php");
    exit;
}

require_once 'core/dbconnect.php';

if (isset($_POST{'contentTitle'}) && isset($_POST{'contentUrl'})) {
    echo $_POST{'contentTitle'}."\n";
    echo $_POST{'contentUrl'}."\n";

    $title = $mysqli->real_escape_string($_POST['contentTitle']);
    $link = $mysqli->real_escape_string($_POST['contentUrl']);

    if (isset($_POST['description'])) {
        $description = $mysqli->real_escape_string($_POST['description']);
    }else {
        $description = null;
    }

    $translateText = $mysqli->real_escape_string($_POST['translateText']);
    $contentType = $mysqli->real_escape_string($_POST['contentType']);

    if (isset($_POST['remove_date'])) {
        $remove_date = $mysqli->real_escape_string($_POST['remove_date']);
    }else {
        $remove_date = null;
    }

    if (htmlspecialchars($_POST['addComent']) == "") {
        $message = "メモなし。";
    }else {
        $message = $mysqli->real_escape_string($_POST['addComent']);
    }

    if (htmlspecialchars($_POST['addTag']) == "") {
        $tage = "none";
    }else {
        $tage = $mysqli->real_escape_string($_POST['addTag']);
    }

    $user_id = $_SESSION['user'];

    $query = "INSERT INTO stock_content_data (
        user_id, title, link, description, translate_text, content_type, remove_date, message, tage
        ) VALUES (
            $user_id, '$title', '$link', '$description', '$translateText', '$contentType', '$remove_date', '$message', '$tage'
        )";

    $result = $mysqli->query($query);
    if (!$result) {
        print('クエリーが失敗しました。' . $mysqli->error);
        $mysqli->close();
        exit();
    }

    $mysqli->close();
}

?>