<?php
session_start();
if( !isset( $_SESSION['login_flg'] ) ) {
    print 'ログインしてください。<a href="index.php">ログイン</a>';
    exit();
}
?>

<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>管理システムメインメニュー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <h1>メニュー</h1>
    <p><input type="button" onclick="location.href='NewItemAdd.php'" value="新規在庫登録"></p>
    <p><input type="button" onclick="location.href='ItemList.php'" value="在庫情報変更"></p>
</body>
</html>