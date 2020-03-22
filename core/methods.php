<?php
require_once 'config.php';

// Google translate method
function translate($str, $mode=false, $tl='ja', $apikey=GOOGLE_API_KEY) {
    $baseUrl = "https://www.googleapis.com/language/translate/v2?";
    $paramAry = array(
        'q' => $str,
        'target' => $tl,
        //'source' => 'en',
        'key' => $apikey
    );
    $param = http_build_query($paramAry);

    $reqUrl = $baseUrl . $param;
    $retJson = file_get_contents($reqUrl, true);
    $ret = json_decode($retJson, true);

    if ($mode === true) {
        return $ret['data']['translations'][0];
    }else {
        return $ret['data']['translations'][0]['translatedText'];
    }
}

// データベースからユーザー情報をハッシュで出力
function db_get_userdata($email, $db_host=DB_HOST, $db_user=DB_USER, $db_pass=DB_PASS, $db_name=DB_NAME) {

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        error_log($mysqli->connect_error);
    exit;
    }

    $query = "SELECT * FROM user_data WHERE email='$email'";
    $result = $mysqli->query($query);

    $result = $mysqli->query($query);
    if (!$result) {
        print('クエリーが失敗しました。' . $mysqli->error);
        $mysqli->close();
        exit();
    }

    $user_data = [];
    while ($row = $result->fetch_assoc()) {
        $user_data['username'] = $row['username'];
        $user_data['email'] = $row['email'];
        $user_data['date'] = $row['registration_date'];
    }

    $result->close();

    return $user_data;
}

// データベース中のユーザーデータの更新
function db_update_userdata($nowemail, $nowpassword, $newusername, $newemail, $newpassword,
    $db_host=DB_HOST, $db_user=DB_USER, $db_pass=DB_PASS, $db_name=DB_NAME) {
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        error_log($mysqli->connect_error);
        exit;
    }else {
        //echo "接続成功";
    }

    $nowemail = $mysqli->real_escape_string($nowemail);
    $nowpassword = $mysqli->real_escape_string($nowpassword);
    $newusername = $mysqli->real_escape_string($newusername);
    $newemail = $mysqli->real_escape_string($newemail);
    $newpassword = $mysqli->real_escape_string($newpassword);
    /*echo "現在メール：".$nowemail."\n";
    echo "現在パス：".$nowpassword."\n";
    echo "新ネーム：".$newusername."\n";
    echo "新メール：".$newemail."\n";
    echo "新パス：".$newpassword."\n";*/

    $query = "SELECT * FROM user_data WHERE email='$nowemail'";
    $result = $mysqli->query($query);

    if (!$result) {
        $func_result = 'クエリーが失敗しました。（パスワードの照合）' . $mysqli->error;
        $mysqli->close();
        //echo 'クエリーが失敗しました。（パスワードの照合）';
        return $func_result;
    }

    while ($row = $result->fetch_assoc()) {
        $db_hashed_pwd = $row['password'];
    }

    if (password_verify($nowpassword, $db_hashed_pwd)) {
        $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $query = "UPDATE user_data SET
            username = '$newusername',
            email = '$newemail',
            password = '$newpassword'
        WHERE email = '$nowemail'";
        $result = $mysqli->query($query);

        if (!$result) {
            $func_result = 'クエリーが失敗しました。（データ更新処理）' . $mysqli->error;
            $mysqli->close();
            //echo 'クエリーが失敗しました。（データ更新処理）';
            return $func_result;
        }

        $func_result = true;

    }else {
        $func_result = "現在のパスワードが一致しません。";
    }

    $mysqli->close();

    return $func_result;
}

// ストックデータの取得
function get_stock_data($user_id, $mode="text", $search_op=false, $keyword="",
    $db_host=DB_HOST, $db_user=DB_USER, $db_pass=DB_PASS, $db_name=DB_NAME) {

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        error_log($mysqli->connect_error);
        exit;
    }

    $query = "SELECT * FROM stock_content_data
            WHERE user_id = '$user_id' AND content_type = '$mode'  ORDER BY stock_date DESC";

    $result = $mysqli->query($query);

    if (!$result) {
        $func_result = 'クエリーが失敗しました。' . $mysqli->error;
        $mysqli->close();
        echo 'クエリーが失敗しました。';
        exit;
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        //$tmp['user_id'] = $row['user_id'];
        $tmp['title'] = $row['title'];
        $tmp['link'] = $row['link'];
        //$tmp['description'] = $row['description'];
        $tmp['translate_text'] = $row['translate_text'];
        //$tmp{'content_type'} = $row['content_type'];
        $tmp['remove_date'] = $row['remove_date'];
        $tmp['message'] = $row['message'];
        $tmp['tage'] = $row['tage'];
        $tmp['number'] = $row['number'];
        $data[] = $tmp;
    }

    $mysqli->close();

    return $data;
}

// IDにマッチしたストックデータを１つ取り出す
function get_stock_uniquedata($user_id, $stock_num,
        $db_host=DB_HOST, $db_user=DB_USER, $db_pass=DB_PASS, $db_name=DB_NAME) {

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        error_log($mysqli->connect_error);
        exit;
    }

    $stock_num = $mysqli->real_escape_string($stock_num);
    $query = "SELECT * FROM stock_content_data
            WHERE number = $stock_num AND user_id = $user_id";

    $result = $mysqli->query($query);

    if (!$result) {
        $func_result = 'クエリーが失敗しました。' . $mysqli->error;
        $mysqli->close();
        echo 'クエリーが失敗しました。';
        exit;
    }

    while ($row = $result->fetch_assoc()) {
        $tmp['title'] = $row['title'];
        $tmp['link'] = $row['link'];
        $tmp['description'] = $row['description'];
        $tmp['translate_text'] = $row['translate_text'];
        $tmp{'content_type'} = $row['content_type'];
        $tmp['remove_date'] = $row['remove_date'];
        $tmp['message'] = $row['message'];
        $tmp['tage'] = $row['tage'];
        $tmp['number'] = $row['number'];
    }

    $mysqli->close();

    return $tmp;
}

//  IDにマッチしたストックデータを更新する
function put_stock_uniquedata($user_id, $stock_num, $dataarray,
        $db_host=DB_HOST, $db_user=DB_USER, $db_pass=DB_PASS, $db_name=DB_NAME) {

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        error_log($mysqli->connect_error);
        exit;
    }

    $user_id = $mysqli->real_escape_string($user_id);
    $content_type = $mysqli->real_escape_string($dataarray['content_type']);
    if (isset($dataarray['update_remove_date'])) {
        $remove_date = $mysqli->real_escape_string($dataarray['update_remove_date']);
    }
    $update_message = $mysqli->real_escape_string($dataarray['update_message']);
    $upadate_tage = $mysqli->real_escape_string($dataarray['upadate_tage']);

    if (isset($dataarray['update_remove_date'])) {
        $query = "UPDATE stock_content_data
                SET content_type = '$content_type', remove_date = '$remove_date', message = '$update_message', tage = '$upadate_tage'
                WHERE number = $stock_num AND user_id = $user_id";
    }else {
        $query = "UPDATE stock_content_data
                SET content_type = '$content_type', message = '$update_message', tage = '$upadate_tage'
                WHERE number = $stock_num AND user_id = $user_id";
    }

    $result = $mysqli->query($query);

    if (!$result) {
        $func_result = 'クエリーが失敗しました。' . $mysqli->error;
        $mysqli->close();
        echo 'クエリーが失敗しました。';
        return false;
    }

    $mysqli->close();

    return true;
}

//  IDにマッチしたストックデータの削除
function delete_stock_uniquedata($user_id, $stock_num,
        $db_host=DB_HOST, $db_user=DB_USER, $db_pass=DB_PASS, $db_name=DB_NAME) {

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        error_log($mysqli->connect_error);
        exit;
    }

    $stock_num = $mysqli->real_escape_string($stock_num);

    $query = "DELETE FROM stock_content_data WHERE number = $stock_num AND user_id = $user_id";

    $result = $mysqli->query($query);

    if (!$result) {
        $func_result = 'クエリーが失敗しました。' . $mysqli->error;
        $mysqli->close();
        echo 'クエリーが失敗しました。';
        return false;
    }

    $mysqli->close();

    return true;
}
?>