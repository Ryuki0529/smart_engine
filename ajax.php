<?php /*
session_start();
if(!isset($_SESSION['user'])) {
    echo "セッションが無効です。";
    //header("Location: login.php");
}*/
?>

<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <script src="js/jquery-3.4.0.min.js"></script>
    </head>
<body>
<form id="test" action="javascript:void(0);">
    <input id="dummy" type="text" name="dummy" /> 
    <input id="test" type="submit" />
</form>

<div id="sample">何か記入してください</div>

<button type="button" id="write">クリア</button>

<script type="text/javascript">
    $(function () {
        $('input#test').click(function () {

        // 一括してフォームデータを取得
        var formData = $('#test').serialize();

            console.log(formData);
                $.ajax({
                    url: "send_mail.php",  //POST送信を行うファイル名を指定
                    type: "POST",
                    data: formData  //POST送信するデータを指定（{ 'hoge': 'hoge' }のように連想配列で直接書いてもOK）
                }).done(function(data) {
                    $('div#sample').html(data);
                });
        });

        $('#write').click(function() {
            $(this).fadeOut(1000);
        });
    });
</script>
</body>