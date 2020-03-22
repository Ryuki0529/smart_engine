<?php
require_once 'dbconnect.php';

$dt = date('Y-m-d');
$query = "DELETE FROM stock_content_data WHERE remove_date = '$dt'";

$result = $mysqli->query($query);
if (!$result) {
    print('クエリーが失敗しました。' . $mysqli->error);
    $mysqli->close();
    exit();
}
/*
$data = [];
while ($row = $result->fetch_assoc()) {
    $tmp['user_id'] = $row['user_id'];
    $tmp['title'] = $row['title'];
    $tmp['link'] = $row['link'];
    $tmp['description'] = $row['description'];
    $tmp['translate_text'] = $row['translate_text'];
    $tmp{'content_type'} = $row['content_type'];
    $tmp['remove_date'] = $row['remove_date'];
    $tmp['message'] = $row['message'];
    $tmp['tage'] = $row['tage'];
    $data[] = $tmp;
}

$result->close();

print_r($data);*/
?>