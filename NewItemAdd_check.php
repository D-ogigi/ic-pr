<?php
session_start();
if (!isset($_SESSION['login_flg'])) {
  print 'ログインしてください。<a href="index.php">ログイン</a>';
  exit();
}
try {
  /* 外部ファイル読み込み */
  require_once('common/common.php');
  /* 内部関数定義 */
  /* POSTデータのサニタイズ */
  function sanitizing($in_data)
  {
    foreach ($in_data as $key => $value) {
      $out_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return ($out_data);
  }
  /* データベース関係の処理 */
  get_database_data($dsn, $user, $password);
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  /* POSTデータのサニタイズ化 */
  $post = sanitizing($_POST);
  if (isset($post['ID']) == false) {
    /* 新規在庫登録処理 */
    /* 商品名が空ではない？ */
    if (!empty($post['KNumber'])) {
      /* 添付ファイルを処理する */
      $temp_file_name_org = '';
      if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($_FILES['upload_file']['tmp_name']);
        $res = finfo_close($finfo);
        /* getimagesize関数で画像情報を取得する */
        list($img_width, $img_height, $mime_type, $attr) = getimagesize($_FILES['upload_file']['tmp_name']);
        switch ($mime_type) {
          /* jpegの場合 */
          case IMAGETYPE_JPEG:
            $img_extension = "jpg";
            break;
          /* pngの場合 */
          case IMAGETYPE_PNG:
            $img_extension = "png";
            break;
          /* gifの場合 */
          case IMAGETYPE_GIF:
            $img_extension = "gif";
            break;
        }
        /* 拡張子が画像だったか？ */
        if (isset($img_extension)) {
          /* ファイルのアップロード */
          $temp_file_name_org = $post['KNumber'] . '_' . date('YmdHis') . '.' . $img_extension;
          $temp_file_name = './image/' . $temp_file_name_org;
          move_uploaded_file($_FILES['upload_file']['tmp_name'], $temp_file_name);
        }
      }
      /* POSTデータをデータベースに登録処理 */
      $sql = 'INSERT INTO goods (KNumber, Maker, PData, Place, Image) VALUES ("' . $post['KNumber'] . '","'
        . $post['Maker'] . '","'
        . $post['PData'] . '","'
        . $post['Place'] . '","'
        . $temp_file_name_org . '");';
      $result = $dbh->query($sql);
    }
    /* 新規在庫登録画面を表示する */
    header('Location:NewItemAdd.php');
  } else {
    /* 在庫情報更新処理 */
    /* POSTデータでテーブルを更新 */
    $sql = 'UPDATE goods SET KNumber="' . $post['KNumber'] . '",'
      . 'Maker="' . $post['Maker'] . '",'
      . 'PData="' . $post['PData'] . '",'
      . 'Place="' . $post['Place'] . '"'
      . ' WHERE ID = ' . $post['ID'];
    $result = $dbh->query($sql);
    /* 添付ファイルを処理する */
    $temp_file_name_org = '';
    if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mime_type = $finfo->file($_FILES['upload_file']['tmp_name']);
      $res = finfo_close($finfo);
      /* getimagesize関数で画像情報を取得する */
      list($img_width, $img_height, $mime_type, $attr) = getimagesize($_FILES['upload_file']['tmp_name']);
      switch ($mime_type) {
        /* jpegの場合 */
        case IMAGETYPE_JPEG:
          $img_extension = "jpg";
          break;
        /* pngの場合 */
        case IMAGETYPE_PNG:
          $img_extension = "png";
          break;
        /* gifの場合 */
        case IMAGETYPE_GIF:
          $img_extension = "gif";
          break;
      }
      /* 拡張子が画像だったか？ */
      if (isset($img_extension)) {
        /* ファイルのアップロード */
        $temp_file_name_org = $post['KNumber'] . '_' . date('YmdHis') . '.' . $img_extension;
        $temp_file_name = './image/' . $temp_file_name_org;
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $temp_file_name);
      }
    }
    /* 添付ファイル名が空ではない？ */
    if (!empty($temp_file_name_org)) {
      $sql = 'SELECT * FROM goods WHERE ID=' . $post['ID'];
      $godds_stmt = $dbh->prepare($sql);
      $godds_stmt->execute();
      $goods_rec = $godds_stmt->fetch(PDO::FETCH_ASSOC);
      /* 更新前の添付ファイルを削除 */
      if ($goods_rec) {
        $file = './image/' . $goods_rec['Image'];
        unlink($file);
      }
      /* 添付ファイル更新 */
      $sql = 'UPDATE goods SET Image="' . $temp_file_name_org . '" WHERE ID = ' . $post['ID'];
      $result = $dbh->query($sql);
    }
    /* 在庫一覧画面を表示する */
    header('Location:ItemList.php');
  }
  exit();
} catch (Exception $e) {
  /* ログイン画面を表示する */
  header('Location:index.php');
  exit();
}
?>