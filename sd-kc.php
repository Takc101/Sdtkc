php
// 本地卡密数据库，实际可以改成MySQL存储，方便管理
$valid_cards = [
    // 格式: 卡密 => [用户ID, 过期时间戳]
    "sdkc000001" => ["user001", strtotimestrtotime"2025-12-31")],
    "sdkc000002" => ["user002", strtotimestrtotime"+30 day")] // 30天后过期
];

header("Content-Type: application/json");

$card = trim($_GET['card'] ?? '');
ifemptyempty($card)){
    echo json_encode([ json_encode([
        'code' => 400, => 400,
        'msg' => '卡密不能为空', => '卡密不能为空',
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
