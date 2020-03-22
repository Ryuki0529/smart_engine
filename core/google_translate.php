<?php
require_once 'config.php';

//------------------------------------
// 定数設定
//------------------------------------
//APIキー
$apiKey = GOOGLE_API_KEY;

// エンドポイント
$baseUrl = "https://www.googleapis.com/language/translate/v2?";

//--------------------------
// 検索キーワード取得
//--------------------------
$query = $GLOBALS['word'];
$lg = 'en';
/*if (isset($_POST['send'])) {
    $query = $_POST['str'];
    $lg = $_POST['lg'];
}*/
//$query = $_GET['q'];

//------------------------------------
// リクエストパラメータ生成
//------------------------------------
$paramAry = array(
                'q' => $query,
                'target' => $lg,
                //'source' => 'en',
                'key' => $apiKey
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
$GLOBALS['word'] = $ret['data']['translations'][0]['translatedText'];

//JSON形式でファイル出力
//file_put_contents(dirname(__FILE__) . "/data/ret_" . "translate" . "_" . date('Ymd_His') . ".json", $retJson);

//項目を画面表示
/*$num = 1;
foreach($ret['items'] as $value){
    echo "順位:" . $num . "<br>\n";
    echo "タイトル:" . $value['snippet']['title'] . "<br>\n";
    echo $before_tag . $value['id']['videoId'] . $after_tag . "<br>\n";
    echo "-------------------------------------------------------------------------<br>\n";

    $num++;
}*/

?>

<!--<form action="" method="post">
    <textarea name="str"></textarea><br/>
    <input type="text" name="lg"><br/>
    <input type="submit" name="send" value="翻訳">
</form>-->