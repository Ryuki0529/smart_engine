<?php
require_once 'config.php';
require_once 'methods.php';

//------------------------------------
// 定数設定
//------------------------------------
//APIキー
$apiKey = GOOGLE_API_KEY;

//検索エンジンID
switch ($_POST['site_filter']) {
    case "general";
        $searchEngineId = CUSTOM_ENGINID;
        break;
    case "qiita";
        $searchEngineId = CUSTOM_ENGINID_QIITA;
        break;
    case "teratail";
        $searchEngineId = GOOGLE_ENGINEID_TERATAIL;
        break;
    case "stackoberflow_ja";
        $searchEngineId = GOOGLE_ENGINEID_JA_SOF;
        break;
    case "stackoberflow_en";
        $searchEngineId = GOOGLE_ENGINEID_EN_SOF;
        break;
    default;
        // 例外値が送信された場合
        $searchEngineId = CUSTOM_ENGINID;
}

// 検索用URL
$baseUrl = "https://www.googleapis.com/customsearch/v1?";

//取得開始位置
$startNum = 1;

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
                'cx' => $searchEngineId,
                'alt' => 'json',
                'start' => $startNum
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
//file_put_contents(dirname(__FILE__) . "/data/ret_" . $startNum . "_" . date('Ymd_His') . ".txt", $retJson);

//項目を画面表示
$num = $startNum;
$trans_request_url = "https://translate.googleusercontent.com/translate_c?depth=1&hl=ja&rurl=translate.google.com&sl=auto&sp=nmt4&tl=ja&u=";
?>

<article class="wow fadeInUp google_custom" data-wow-duration="0.5s" data-wow-delay="0.5s">
    <h2><i class="fab fa-wpforms"></i>&nbsp;Webページの検索結果</h2>
    <?php foreach($ret['items'] as $value): ?>
        <section class="wow fadeInUp google_custom_item" data-wow-duration="0.5s" data-wow-delay="1s">
            <p class="number"><span><?php echo "結果：" . $num ; ?></span></p>&nbsp;
            <div class="webpage_title"><a href="<?php echo $value['link']; ?>" target="_blank"><?php echo $value['htmlTitle'] . "<br>\n"; ?></a></div>
            <?php if ($GLOBALS['snippet_translate'] === true): ?>
                <p class="webpage_trans">日本語訳：<?php echo translate($value['title']); ?></p>
            <?php elseif ($GLOBALS['snippet_translate_judg'] === true): ?>
                <?php $trans_data = translate($value['title'], true); ?>
                <?php if ($trans_data['detectedSourceLanguage'] === 'en'): ?>
                    <p class="webpage_trans">日本語訳：<?php echo $trans_data['translatedText']; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <p class="webpage_description"><?php echo $value['htmlSnippet'] . "<br>\n"; ?></p>
            <div class="contents_operation_area"><center>
                <?php if ($GLOBALS['login'] ===  true && (($GLOBALS['snippet_translate_judg'] === true && $trans_data['detectedSourceLanguage'] === 'en') || $GLOBALS['snippet_translate'] === true)): ?>
                    <a href="<?php echo $trans_request_url.$value['link']; ?>" target="_blank" class="translate_btn"><i class="fas fa-globe"></i>&nbsp;翻訳</a>&nbsp;
                <?php endif; ?>
                <?php if ($GLOBALS['login'] ===  true): ?>
                    <button class="send_mail_btn_web"><i class="fas fa-envelope-open"></i>&nbsp;メール送信</button>&nbsp;
                    <button class="stock_text_btn"><i class="fas fa-folder-open"></i>&nbsp;ストック</button>
                <?php endif; ?>
            </center></div>
            <?php $num++; ?>
        </section>
    <?php endforeach; ?>
</article>