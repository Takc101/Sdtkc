<?php
// 本地卡密数据库，实际可以改成MySQL存储，方便管理
$valid_cards = [
    // 格式: 卡密 => [用户ID, 过期时间戳]
    "test123456" => ["user001", strtotime("2025-12-31")],
    "test654321" => ["user002", strtotime("+30 day")] // 30天后过期
];

header("Content-Type: application/json");

$card = trim($_GET['card'] ?? '');
if(empty($card)){
    echo json_encode([
        'code' => 400,
        'msg' => '卡密不能为空',
        'data' => null
    ]);
    exit;
}

if(!isset($valid_cards[$card])){
    echo json_encode([
        'code' => 401,
        'msg' => '卡密不存在',
        'data' => null
    ]);
    exit;
}

$info = $valid_cards[$card];
$expire = $info[1];
$now = time();

if($expire < $now){
    echo json_encode([
        'code' => 402,
        'msg' => '卡密已过期',
        'data' => null
    ]);
    exit;
}

echo json_encode([
    'code' => 200,
    'msg' => '授权成功',
    'data' => [
        'uid' => $info[0],
        'expire' => $expire
    ]
]);
exit;
?>
