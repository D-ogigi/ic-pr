<?php
session_start();
if (!isset($_SESSION['login_flg'])) {
  print 'ログインしてください。<a href="index.php">ログイン</a>';
  exit();
}
try {
  if (isset($_GET['ID']) == true) {
    /* 外部ファイル読み込み */
    require_once('common/common.php');
    /* データベース関係の処理 */
    get_database_data($dsn, $user, $password);
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /* レコード削除処理 */
    /* 添付ファイルを削除 */
    $sql = 'SELECT * FROM goods WHERE ID=' . $_GET['ID'];
    $godds_stmt = $dbh->prepare($sql);
    $godds_stmt->execute();
    $goods_rec = $godds_stmt->fetch(PDO::FETCH_ASSOC);
    if ($goods_rec) {
      $file = './image/' . $goods_rec['Image'];
      unlink($file);
    }
    /* POSTデータをデータベースに登録処理 */
    $sql = 'DELETE FROM goods WHERE ID=' . $_GET['ID'];
    $result = $dbh->query($sql);
  }
  /* 在庫一覧画面を表示する */
  header('Location:ItemList.php');
  exit();
} catch (Exception $e) {
  /* ログイン画面を表示する */
  header('Location:index.php');
  exit();
}
?>