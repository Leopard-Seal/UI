<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>APIテスト</title>
</head>
<body>
    <h1>APIテスト</h1>
    
    <?php
    $apiResponse = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userInput = $_POST['userInput'] ?? '';
        $apiResponse = sendToAPI($userInput);
    }

    function sendToAPI($userInputValue) {
        $apiEndpoint = 'http://localhost:8000/generate/'; // あなたのAPIエンドポイントURL
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode(['text' => $userInputValue]),
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($apiEndpoint, false, $context);

        if ($result === FALSE) {
            return 'エラー: ネットワークレスポンスが正常ではありません。';
        } else {
            $data = json_decode($result, true);
            return '結果: ' . $data['result'];
        }
    }
    ?>

    <form method="post">
        <input type="text" name="userInput" placeholder="テキストを入力" value="<?php echo htmlspecialchars($userInput ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">送信</button>
    </form>
    <div id="apiResponse"><?php echo htmlspecialchars($apiResponse, ENT_QUOTES, 'UTF-8'); ?></div>
    
</body>
</html>