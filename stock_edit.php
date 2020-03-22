<?php
session_start();
include_once 'core/dbconnect.php';
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    //$GLOBALS['login'] = false;
    exit;
}else {
    $GLOBALS['login'] =  true;
}

require_once './core/methods.php';

require_once './core/user_data_lood.php';

$ms = "";
if (isset($_POST['update_stock_btn'])) {
    $update_tmp['content_type'] = htmlspecialchars($_POST['content_type']);
    if (isset($_POST['update_remove_date'])) {
        $update_tmp['update_remove_date'] = htmlspecialchars($_POST['update_remove_date']);
    }
    $update_tmp['update_message'] = htmlspecialchars($_POST['update_message']);
    $update_tmp['upadate_tage'] = htmlspecialchars($_POST['upadate_tage']);
    $stock_number = htmlspecialchars($_POST['unique_number']);

    $resalt = put_stock_uniquedata($_SESSION['user'], $stock_number, $update_tmp);

    if ($resalt == true) {
        $ms = "<p class='alert_1'>データを更新しました。</p>";
    }else {
        $ms = "<p class='alert_2'>データの更新に失敗しました。</p>";
    }
}

$stock_data = get_stock_uniquedata($_SESSION['user'], $_GET['number']);
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
    <div class="container">
        <h2 class="wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.6s">ストックの詳細表示と編集</h2>
        <?php echo $ms; ?>
        <?php if (isset($_GET['number'])): ?>
            <form action="" method="post" class="wow fadeInUp stock_update_form" data-wow-duration="2s" data-wow-delay="0.6s">
                <label>タイトル</label>
                <div class="update_stock_input_data"><a href="<?php echo $stock_data['link'] ?>" target="_blank"><?php echo $stock_data['title'] ?></a></div>
                <?php if ($stock_data['translate_text'] != "翻訳なし。"): ?>
                    <label>タイトルの翻訳テキスト</label>
                    <div class="update_stock_input_data"><p><?php echo $stock_data['translate_text'] ?></p></div>
                <?php endif; ?>
                <?php if ($stock_data['content_type'] == "text"): ?>
                    <label>ディスクリプション</label>
                    <div class="update_stock_input_data"><p><?php echo $stock_data['description'] ?></p></div>
                <?php elseif ($stock_data['content_type'] == "movie"): ?>
                    <?php $fream = str_replace("https://youtu.be/", "", $stock_data['link']); ?>
                    <label>動画プレビュー</label>
                    <div class="update_stock_input_data"><div class="movie-wrap"><iframe src='https://www.youtube.com/embed/<?php echo $fream; ?>' frameborder='0'allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div></div>
                <?php endif; ?>
                <label for="update_content_type">コンテンツ種別</label>
                <div class="update_stock_input_data">
                <select name="content_type" if="update_content_type">
                    <?php
                        $selected['text'] = "";
                        $selected['movie'] = "";
                        if ($stock_data['content_type'] == "text") {
                            $selected['text'] = "selected";
                        }elseif ($stock_data['content_type'] == "movie") {
                            $selected['movie'] = "selected";
                        }
                    ?>
                    <option value="text" <?php echo $selected['text'] ?>>テキストコンテンツ</option>
                    <option value="movie" <?php echo $selected['movie'] ?>>動画コンテンツ</option>
                </select>
                </div>
                <label for="update_remove_date"><input id="update_stock_remove_date" type="checkbox" name="update_remove_date_visable">&nbsp;ストック期限の更新</label>
                <div class="update_stock_input_data"><input disabled id="update_remove_date_visable" type="date" name="update_remove_date" value="<?php echo $stock_data['remove_date'] ?>" min="<?php echo date('Y-m-d'); ?>"></div>
                <label for="update_message">メモ</label>
                <div class="update_stock_input_data"><textarea name="update_message" id="update_message"><?php echo $stock_data['message'] ?></textarea></div>
                <label for="upadate_tage">タグ</label>
                <div class="update_stock_input_data"><input type="text" name="upadate_tage" id="upadate_tage" value="<?php echo $stock_data['tage'] ?>"></div>
                <input type="hidden" name="unique_number" value="<?php echo $stock_data['number'] ?>">
                <input class="update_stock_submit" type="submit" name="update_stock_btn" value="更新する">
                <button class="update_stock_back" type="button" onclick="history.back()">戻る</button>
            </form>
        <?php else: ?>
            <p>URLパラメータが不正です。</p>
        <?php endif; ?>
        <?php //print_r(get_stock_uniquedata($_SESSION['user'], $_GET['number'])) ?>
    </div>
    <footer>
        <?php require_once 'include/footer_content.php'; ?>
    </footer>
</body>
</html>
