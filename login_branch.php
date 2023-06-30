<?php
try{
/* 内部定数定義 */
    /* 事前に決めたIDとパスワードを取り込む */
    $LOGIN_ID   = 'sukimadou';
    $LOGIN_PASS = 'password';
/* 内部関数定義 */
    /* POSTデータのサニタイズ */
    function sanitizing($in_data){
        foreach($in_data as $key=>$value){
            $out_data[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
        }
        return($out_data);
    }
/* ログイン処理 */
    /* POSTデータのサニタイズ化 */
    $post=sanitizing($_POST);

    /* POSTデータを内部変数に設定 */
    $login_id   = $post['login_id'];
    $login_pass = $post['pass'];

    /* POSTデータが事前に決めたデータと不一致しているか？ */
    if(($LOGIN_ID != $login_id) || (md5($LOGIN_PASS) != md5($login_pass))){
        /* ログイン画面を表示する */
        header('Location:index.php');
        exit();
    }else{
        /* セッション開始/セッション情報更新 */
        if( !isset( $_SESSION ) ) {
            session_start();
        }else{
            session_regenerate_id( true );
        }
        $_SESSION['login_flg']=1;
        /* メインメニューを表示 */
        header('Location:MainMenu.php');
        exit();
    }
}catch(Exception $e){
        /* ログイン画面を表示する */
        header('Location:index.php');
        exit();
}
?>