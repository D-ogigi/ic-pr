<?php
session_start();
if (!isset($_SESSION['login_flg'])) {
    print 'ログインしてください。<a href="index.php">ログイン</a>';
    exit();
}
/* 外部ファイル読み込み */
require_once('common/common.php');
/* データベース関係の処理 */
get_database_data($dsn, $user, $password);

try{
    $dbh = new PDO($dsn, $user, $password);
}catch(PDOException $e){
    print('connection faild:'.$e->getMessage());
}

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/* クエリがあれば、現テーブルデータを読み出す */
if (isset($_GET['code']) == true) {
    $sql = 'SELECT * FROM goods WHERE code=' . $_GET['code'];
    $godds_stmt = $dbh->prepare($sql);
    $godds_stmt->execute();
    $goods_rec = $godds_stmt->fetch(PDO::FETCH_ASSOC);
    if ($goods_rec == false)
        unset($goods_rec);
}
?>

<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>管理システム新規機材登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php
    if (isset($goods_rec) == true) {
        print '<h1>在庫情報更新画面</h1>';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <form method="post" action="NewItemAdd_check.php" enctype="multipart/form-data">
        <p>型式型番<input type="text" name="KNumber" required></p>
        <p>メーカー<input type="text" name="Maker"></p>
        <p>購入日<input type="text" name="PData"></p>
        <p>保管場所<input type="text" name="Place"></p>
        <p>画像<input type="file" name="upload_file" accept="image/*"></p>
        <?php
        if (isset($goods_rec) == true) {
            print '<p><b>↑画像を変更しない場合</b>は、ファイルを選択しないでください。</p>';
            print '<p><img src="./image/' . $goods_rec['Image'] . '" height="100px", width="100px"></p>';
            print '<p><input type="hidden" name="code" value="' . $goods_rec['code'] . '"></p>';
        }
        ?>
        <p><input type="submit" value="登録">
            <?php
            if (isset($goods_rec) == true) {
                print '<input type="button" onclick="location.href=\'ItemDelete.php?code=' . $goods_rec['code'] . '\'"   value="削除">';
            }
            ?>
        </p>
    </form>
    <hr>
    <p><input type="button" onclick="location.href='MainMenu.php'" value="メインメニュー"></p>
    <p><input type="button" onclick="location.href='NewItemAdd.php'" value="新規在庫登録"></p>
    <p><input type="button" onclick="location.href='ItemList.php'" value="在庫情報一覧"></p>
    <script>
        <?php
        if (isset($goods_rec) == true) {
            print 'var element = document.querySelector(\'input[name="KNumber"]\');';
            print 'element.value = "' . $goods_rec['KNumber'] . '";';
            print 'element = document.querySelector(\'input[name="Maker"]\');';
            print 'element.value = "' . $goods_rec['Maker'] . '";';
            print 'element = document.querySelector(\'input[name="PData"]\');';
            print 'element.value = "' . $goods_rec['PData'] . '";';
            print 'element = document.querySelector(\'input[name="Place"]\');';
            print 'element.value = "' . $goods_rec['Place'] . '";';
        }
        ?>
    </script>
</body>

</html>