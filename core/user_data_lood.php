<?php
if ($GLOBALS['login'] === true) {
    // ユーザーIDからユーザー名を取り出す
    $query = "SELECT * FROM user_data WHERE user_id=".$_SESSION['user']."";
    $result = $mysqli->query($query);

    $result = $mysqli->query($query);
    if (!$result) {
        print('クエリーが失敗しました。' . $mysqli->error);
        $mysqli->close();
        exit();
    }

    // ユーザー情報の取り出し
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        //echo $row['username'];
        $email = $row['email'];
    }

    // データベースの切断
    $result->close();
}
?>