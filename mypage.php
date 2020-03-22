<?php
session_start();
include_once 'core/dbconnect.php';
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    //$GLOBALS['login'] = false;
}else {
    $GLOBALS['login'] =  true;
}

require_once './core/user_data_lood.php';
require_once './core/methods.php';

if (isset($_POST['update_data'])) {
    $msg = "";
    if ($_POST['mailaddress'] === $_POST['mailaddress_a']) {
        if ($_POST['newpassword'] === $_POST['newpassword_a']) {
            $db_error = db_update_userdata($_SESSION['email'], $_POST['nowpassword'], $_POST['username'],
                $_POST['mailaddress'], $_POST['newpassword']);
            if ($db_error === true) {
                $msg = "<p class='alert_1'>登録情報を変更しました。</p>";
                $_SESSION['email'] = htmlspecialchars($_POST['mailaddress']);
                $username = htmlspecialchars($_POST['username']);
            }else {
                $msg = "<p class='alert_2'>処理が失敗：".$db_error."</p>";
            }
        }else {
            $msg = "<p class='alert_2'>新しいパスワードが一致しません。</p>";
        }
    }else {
        $msg = "<p class='alert_2'>メールアドレスが一致しません。</p>";
    }
}

$del_stock_ms = "";
if (isset($_GET['delnum'])) {
    if ($resalt = delete_stock_uniquedata($_SESSION['user'], $_GET['delnum'])) {
        $del_stock_ms = "<p class='alert_1'>１つのコンテンツを削除しました。</p>";
    }
}

if (isset($_GET['stock'])) {
    $stock_webpage_data = get_stock_data($_SESSION['user']);
    $stock_movie_data = get_stock_data($_SESSION['user'], "movie");
}
?>

<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <?php require_once 'include/head_load.php'; ?>
    </head>
<body>
    <header class="wow fadeInDown" data-wow-duration="2s" data-wow-delay="0.4s">
        <?php require_once 'include/header_content.php'; ?>
    </header>
    <?php require_once 'include/search_form.php' ?>
    <div class="wow fadeInUp container" data-wow-duration="2s" data-wow-delay="0.4s">
        <h2>マイページ</h2>
        <ul class="mymenu">
            <li><a href="./mypage.php?stock">ストック一覧</a></li>
            <li><a href="./mypage.php?setting">登録情報変更</a></li>
        </ul>
        <?php echo $del_stock_ms; ?>
        <div class="update_area">
            <?php if (isset($_GET['setting'])): ?>
            <h3>登録情報</h3>
                <?php $user_data = db_get_userdata($_SESSION['email']) ?>
                <div class="user_data_item">
                    <label for="nowusername">ユーザーネーム</label>
                    <span class="user_data" id="nowusername"><?php echo $user_data['username'] ?></span>
                </div>
                <div class="user_data_item">
                    <label for="nowemail">メールアドレス</label>
                    <span class="user_data" id="nowemail"><?php echo $user_data['email'] ?></span>
                </div>
                <div class="user_data_item">
                    <label for="date">登録日時</label>
                    <span class="user_data" id="date"><?php echo $user_data['date'] ?></span>
                </div>
                <!--<p><?php //echo $_SESSION['email'] ?></p>-->
            <h3>登録情報の更新</h3>
            <?php echo $msg; ?>
            <form method="post" action="">
                <div class="update_item">
                    <label for="username">ユーザーネーム</label>
                    <input type="text" name="username" id="username" placeholder="ここにユーザーネームを入力">
                </div>
                <div class="update_item">
                    <label for="mailaddress">メールアドレス</label>
                    <input type="email" name="mailaddress" id="mailaddress" placeholder="ここにメールアドレスを入力">
                </div>
                <div class="update_item">
                    <label for="mailaddress_a">メールアドレス（確認）</label>
                    <input type="email" name="mailaddress_a" id="mailaddress_a" placeholder="ここに確認メールアドレスを入力">
                </div>
                <div class="update_item">
                    <label for="nowpassword">現在のパスワード</label>
                    <input type="password" name="nowpassword" id="nowpassword" placeholder="ここに現在のパスワードを入力">
                </div>
                <div class="update_item">
                    <label for="newpassword">新しいパスワード</label>
                    <input type="password" name="newpassword" id="newpassword" placeholder="ここに新しいパスワードを入力">
                </div>
                <div class="update_item">
                    <label for="newpassword_a">新しいパスワード（確認）</label>
                    <input type="password" name="newpassword_a" id="newpassword_a" placeholder="ここに確認用新しいパスワードを入力">
                </div>
                <input class="update_btn" type="submit" name="update_data" value="変更する">
            </form>
            <?php elseif (isset($_GET['stock'])): ?>
            <h3>ストック一覧の表示（Webページ）</h3>
            <p><?php
                if (empty($stock_webpage_data)) {
                    echo "まだストックがありません。";
                }
            ?></p>
            <article class="google_custom">
            <?php $trans_request_url = "https://translate.googleusercontent.com/translate_c?depth=1&hl=ja&rurl=translate.google.com&sl=auto&sp=nmt4&tl=ja&u="; ?>
            <?php foreach ($stock_webpage_data as $data): ?>
                <section class="google_custom_item" style="padding-bottom: 63px;">
                <div class="webpage_title"><a href="<?php echo $data['link']; ?>" target='_blank'><?php echo $data['title']; ?></a></div>
                    <?php if ($data['translate_text'] !== "翻訳なし。"): ?>
                        <p class="webpage_trans"><?php echo $data['translate_text']; ?></p>
                    <?php endif; ?>
                    <p>メモ：<?php echo $data['message'] ?></p>
                    <p>
                        <span>ストック期限：<?php
                            if ($data['remove_date'] === "0000-00-00") {
                                echo "無期限";
                            }else {
                                echo $data['remove_date'];
                            }
                        ?></span>&emsp;
                        <span>タグ：<?php
                            if ($data['tage'] === "none") {
                                echo "なし";
                            }else {
                                echo $data['tage'];
                            }
                        ?></span>
                    </p>
                    <div class="contents_operation_area" <?php echo $style1; ?>><center>
                        <?php if ($data['translate_text'] !== "翻訳なし。"): ?>
                            <a href="<?php echo $trans_request_url.$data['link']; ?>" target="_blank" class="translate_btn"><i class="fas fa-globe"></i>&nbsp;翻訳</a>&nbsp;
                        <?php endif; ?>
                        <button class="send_mail_btn_web"><i class="fas fa-envelope-open"></i>&nbsp;メール</button>&nbsp;
                        <a class="stock_details_btn" href="<?php echo "stock_edit.php?number=".$data['number']; ?>"><i class="fas fa-edit"></i>&nbsp;詳細</a>&nbsp;
                        <a <?php echo $style2; ?> class="stock_delete_btn" href="mypage.php?stock&delnum=<?php echo $data['number']; ?>"><i class="fas fa-trash-alt"></i>&nbsp;削除</a>
                    </center></div>
                </section>
            <?php endforeach; ?>
            </article>
            <h3>ストック一覧の表示（動画）</h3>
            <p><?php
                if (empty($stock_movie_data)) {
                    echo "まだストックがありません。";
                }
            ?></p>
            <article class="youtube_search">
                <?php foreach ($stock_movie_data as $data): ?>
                    <section class="youtube_search_item" style="padding-bottom: 63px;">
                        <div class="movie-wrap">
                            <?php $fream = str_replace("https://youtu.be/", "", $data['link']); ?>
                            <iframe src='https://www.youtube.com/embed/<?php echo $fream; ?>' frameborder='0'allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                        </div>
                        <div class="movie_title">
                            <a class="youtube_title_link" href="<?php echo $data['link'] ?>" target="_blank"><?php echo $data['title'] ?></a>
                            <?php if ($data['translate_text'] !== "翻訳なし。"): ?>
                                <p class="webpage_trans"><?php echo $data['translate_text']; ?></p>
                            <?php endif; ?>
                            <p>メモ：<?php echo $data['message'] ?></p>
                        </div>
                        <p>
                        <span style="display:inline; width:auto;">ストック期限：<?php
                            if ($data['remove_date'] === "0000-00-00") {
                                echo "無期限";
                            }else {
                                echo $data['remove_date'];
                            }
                        ?></span>&emsp;
                        <span style="display:inline; width:auto;">タグ：<?php
                            if ($data['tage'] === "none") {
                                echo "なし";
                            }else {
                                echo $data['tage'];
                            }
                        ?></span>
                    </p>
                    <div class="contents_operation_area"><center>
                        <button class="send_mail_btn_movie"><i class="fas fa-envelope-open"></i>&nbsp;メール送信</button>&nbsp;
                        <a class="stock_details_btn" href="<?php echo "stock_edit.php?number=".$data['number']; ?>"><i class="fas fa-edit"></i>&nbsp;詳細</a>&nbsp;
                        <a class="stock_delete_btn" href="mypage.php?stock&delnum=<?php echo $data['number']; ?>"><i class="fas fa-trash-alt"></i>&nbsp;削除</a>
                    </center></div>
                    </section>
                <?php endforeach; ?>
            </article>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <?php require_once 'include/footer_content.php'; ?>
    </footer>
</body>
</html>
