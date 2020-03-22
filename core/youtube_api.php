<?php
require_once 'config.php';
require_once 'methods.php';

//------------------------------------
// 定数設定
//------------------------------------
//APIキー
$apiKey = GOOGLE_API_KEY;

// 検索用URL
$baseUrl = "https://www.googleapis.com/youtube/v3/search?";

// 動画の埋め込みダグ
$before_tag = "<iframe src='https://www.youtube.com/embed/";
$after_tag = "' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";

//--------------------------
// 検索キーワード取得
//--------------------------
//$query = $_POST['q'];
//$query = $_GET['q'];
$query = $GLOBALS['word'];

//------------------------------------
// リクエストパラメータ生成
//------------------------------------
$paramAry = array(
                'q' => $query,
                'key' => $apiKey,
                'type' => 'video',
                'part' => 'snippet',
                'maxResults' => 10
);
$param = http_build_query($paramAry);

//------------------------------------
// 実行＆結果取得
//------------------------------------
$reqUrl = $baseUrl . $param;
$retJson = file_get_contents($reqUrl, true);
$ret = json_decode($retJson, true);

//------------------------------------
// 結果表示
//------------------------------------

//画面表示
//var_dump($ret);

//JSON形式でファイル出力
//file_put_contents(dirname(__FILE__) . "/data/ret_" . "youtube" . "_" . date('Ymd_His') . ".json", $retJson);

//項目を画面表示
$num = 1;
?>

<article class="wow fadeInUp youtube_search" data-wow-duration="0.5s" data-wow-delay="0.5s">
    <h2><i class="fas fa-video"></i>&nbsp;動画の検索結果</h2>
    <?php foreach($ret['items'] as $value): ?>
        <section class="wow fadeInUp youtube_search_item" data-wow-duration="0.5s" data-wow-delay="1s">
            <span><?php echo "結果：" . $num . "<br>\n"; ?></span>
            <div class="movie-wrap"><?php echo $before_tag . $value['id']['videoId'] . $after_tag . "<br>\n";?></div>
            <div class="movie_title">
                <a href="https://youtu.be/<?php echo $value['id']['videoId']; ?>" target="_blank" class="youtube_title_link"><?php echo $value['snippet']['title']; ?></a>
            </div>
            <?php if ($GLOBALS['snippet_translate'] === true): ?>
                <p class="movie_title_translate">日本語訳：<?php echo translate($value['snippet']['title']); ?></p>
            <?php elseif ($GLOBALS['snippet_translate_judg'] === true): ?>
                <?php $trans_data = translate($value['snippet']['title'], true); ?>
                <?php if ($trans_data['detectedSourceLanguage'] === 'en'): ?>
                    <p class="movie_title_translate">日本語訳：<?php echo $trans_data['translatedText']; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <div class="contents_operation_area"><center>
                <?php if ($GLOBALS['login'] ===  true): ?>
                    <button class="send_mail_btn_movie"><i class="fas fa-envelope-open"></i>&nbsp;メール送信</button>&nbsp;
                    <button class="stock_movie_btn"><i class="fas fa-folder-open"></i>&nbsp;ストック</button>
                <?php endif; ?>
            </center></div>
            <?php $num++; ?>
        </section>
    <?php endforeach; ?>
</article>