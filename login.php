<?php
ob_start();
session_start();
if( isset($_SESSION['user']) != "") {
    header("Location: /.");
}

include_once 'core/dbconnect.php';
?>
<?php
// ログインボタンがクリックされたときに下記を実行
if(isset($_POST['login'])) {

    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // クエリの実行
    $query = "SELECT * FROM user_data WHERE email='$email'";
    $result = $mysqli->query($query);
    if (!$result) {
        print('クエリーが失敗しました。' . $mysqli->error);
        $mysqli->close();
        exit();
    }

    // パスワード(暗号化済み）とユーザーIDの取り出し
    while ($row = $result->fetch_assoc()) {
        $db_hashed_pwd = $row['password'];
        $user_id = $row['user_id'];
    }

    // データベースの切断
    $result->close();

    // ハッシュ化されたパスワードがマッチするかどうかを確認
    if (password_verify($password, $db_hashed_pwd)) {
        $_SESSION['user'] = $user_id;
        $_SESSION['email'] = $email;
        header("Location: /.");
        exit;
    } else {
        ob_start(); ?>
        <div class="alert alert-danger" role="alert">メールアドレスとパスワードが一致しません。</div>
        <?php $data = ob_get_clean();
    }
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ログイン機能｜SMART ENGINE</title>
<link rel="stylesheet" href="css/style.css">
<style>
    h1::before {
        display: none;
    }
</style>
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
</head>
<body>
<div class="container">

<form method="post">
    <h1>SMART ENGINE｜ログインフォーム</h1>
    <?php echo $data; ?>
    <div class="form-group">
        <input type="email"  class="form-control" name="email" placeholder="メールアドレス" required />
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
    </div>
    <button type="submit" class="btn btn-default" name="login">ログインする</button>
    <a href="register.php">会員登録はこちら</a>
</form>

</div>
</body>
</html>
