<?php
session_start();
include_once 'core/dbconnect.php';
if(!isset($_SESSION['user'])) {
    //header("Location: login.php");
    $GLOBALS['login'] = false;
}else {
    $GLOBALS['login'] =  true;
}

require_once './core/methods.php';

require_once './core/user_data_lood.php';

if (isset($_POST['seach'])) {
    if ($_POST['translate'] === 'ja') {
        $GLOBALS['word'] = htmlspecialchars($_POST['str']);
        $GLOBALS['snippet_translate'] = false;
    }elseif ($_POST['translate'] === 'en') {
        $GLOBALS['word'] = htmlspecialchars($_POST['str']);
        $GLOBALS['snippet_translate_judg'] = true;
    }elseif ($_POST['translate'] === 'en_search') {
        $GLOBALS['word'] = htmlspecialchars($_POST['str']);
        $GLOBALS['snippet_translate'] = true;
        require_once './core/google_translate.php';
    }
}
?>

<!DOCTYPE HTML>
<html lang="ja" prefix="og: http://ogp.me/ns#">
    <head>
        <?php require_once 'include/head_load.php'; ?>
    </head>
<body>
    <header class="wow fadeInDown" data-wow-duration="2s" data-wow-delay="0.4s">
        <?php require_once 'include/header_content.php'; ?>
    </header>
    <?php require_once 'include/search_form.php' ?>
    <div class="container">
        <?php if (isset($_POST['seach'])): ?>
            <?php if (in_array("google", $_POST['language']) === true): ?>
                <?php require_once './core/google_custom_api.php'; ?>
            <?php endif; ?>
            <?php if (in_array("youtube", $_POST['language']) === true): ?>
                <?php require_once './core/youtube_api.php'; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_POST['seach'])): ?>
            <div class="news"><?php require_once 'include/news.php'; ?></div>
        <?php endif; ?>
    </div>
    <div id="pace_run"></div>
    <footer>
        <?php require_once 'include/footer_content.php'; ?>
    </footer>
</body>
</html>
