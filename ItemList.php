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
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>

<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <title>管理システム機材一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <?php
  /* 在庫一覧表示処理 */
  $sql = 'SELECT * FROM goods WHERE 1';
  $godds_stmt = $dbh->prepare($sql);
  $godds_stmt->execute();
  while (true) {
    $goods_rec = $godds_stmt->fetch(PDO::FETCH_ASSOC);
    if ($goods_rec == false)
      break;
    print '<figure class="thumbnail"><input type="hidden" id="thumbnail' . $goods_rec['ID'] . '" name="thumbnail' . $goods_rec['ID'] . '" value="' . $goods_rec['ID'] . '">'
      . '<img src="./image/' . $goods_rec['Image'] . '" height="200px", width="200px">'
      . '<table>'
      . '<tr><td>型式型番</td><td>：' . $goods_rec['KNumber'] . '</td></tr>'
      . '<tr><td>メーカー</td><td>：' . $goods_rec['Maker'] . '</td></tr>'
      . '<tr><td>購入日</td><td>：' . $goods_rec['PData'] . '円</td></tr>'
      . '<tr><td>保管場所</td><td>：' . $goods_rec['Place'] . '円</td></tr>'
      . '</table>'
      . '</figure>';
  }
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const thumbnails = document.querySelectorAll('.thumbnail');
      for (var i = 0; i < thumbnails.length; i++) {
        thumbnails[i].addEventListener('click', function () {
          const firstChild = this.firstElementChild;
          location.href = 'NewItemAdd.php?code=' + firstChild.value;
        }, false);
      }
    }, false);
  </script>
  <hr>
  <p><input type="button" onclick="location.href='MainMenu.php'" value="メインメニュー"></p>
  <p><input type="button" onclick="location.href='NewItemAdd.php'" value="新規在庫登録"></p>
  <p><input type="button" onclick="location.href='ItemList.php'" value="在庫情報一覧"></p>
</body>

</html>