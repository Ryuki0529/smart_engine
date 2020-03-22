<?php
session_start();
if( isset($_SESSION['user']) != "") {
    // ログイン済みの場合はリダイレクト
    header("Location: index.php");
}

// DBとの接続
include_once 'core/dbconnect.php';

// signupがPOSTされたときに下記を実行
if(isset($_POST['signup'])) {

    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);

    if ($_POST['passwordConfirm'] === $_POST['password']) {

        $password = $mysqli->real_escape_string($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $data = date('Y-m-d H:i:s');

        // POSTされた情報をDBに格納する
        $query = "INSERT INTO user_data(
            username, email, password, registration_date
            )
            VALUES('$username','$email','$password', '$data'
            )";

        if($mysqli->query($query)) {
            ob_start(); ?>
            <div class="alert alert-success" role="alert">登録しました。５秒後にログインページに繊維します。</div>
            <?php $data = ob_get_clean();
            ob_start(); ?>
            <meta http-equiv="refresh" content="5; url=login.php">
            <?php $redirect = ob_get_clean();
            $username = "";
            $email= ""; ?>
            <?php } else { ?>
            <div class="alert alert-danger" role="alert">エラーが発生しました。</div>
        <?php }
    }else {
        ob_start(); ?>
        <div class="alert alert-danger" role="alert">パスワードと確認用パスワードが一致しません。</div>
        <?php $data = ob_get_contents();
        ob_end_clean();
    }
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo $redirect; ?>
<title>PHPの会員登録機能｜SMART ENGINE</title>
<link rel="stylesheet" href="css/style.css">
<style>
    h1::before {
        display: none;
    }
</style>
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<form method="post">
    <h1>SMART ENGINE｜会員登録フォーム</h1>
    <?php echo $data; ?>
    <div class="form-group">
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" placeholder="ユーザー名" required />
    </div>
    <div class="form-group">
        <input type="email" value="<?php echo $email; ?>" class="form-control" name="email" placeholder="メールアドレス" required />
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="passwordConfirm" placeholder="パスワード確認" required />
    </div>
    <button type="submit" class="btn btn-default" name="signup">会員登録する</button>
    <a href="login.php".php">ログインはこちら</a>
</form>
</div>
</body>
</html>
