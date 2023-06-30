<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>管理システムログインページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <h1>機材管理システム</h1>
    <form method="post" action="login_branch.php">
        <p>ログインID
        <input type="text" name="login_id"></p>
        <p>パスワード
        <input type="password" name="pass"></p>
        <input type="submit" value="ログイン">
    </form>
</body>
</html>