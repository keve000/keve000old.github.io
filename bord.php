<?php
//変数
$name = "";
$title = "";
$sentence = "";
$errorCount = array();
// 日付
date_default_timezone_set('Asia/Tokyo');
$today = date("Y/m/d H:i:s");
// 入力された値のチェック
if(!isset($_POST["name"]) || !is_string($_POST["name"])){
  $errorCount['nameERROR'] = '1';
  $name = '不正な名前';
}elseif($_POST["name"] === ''){
  $name = "名無し";
}else{
  $name = $_POST["name"];
}
if(!isset($_POST["title"]) || !is_string($_POST["title"])){
  $errorCount['titleERROR'] = '1';
  $title = '不正なtitle';
}elseif($_POST["title"] === ''){
  $title = "無題";
}else{
  $title = $_POST["title"];
}
if (!isset($_POST["sentence"]) || !is_string($_POST["sentence"])){
  $errorCount['sentenceERROR'] = '1';
  $sentence = null;
}elseif ($_POST["sentence"] === ''){
  $errorCount['sentenceERROR'] = '2';
  $sentence ="";
}else {
  $sentence = $_POST["sentence"];
}
//投稿

 if(isset($_POST["SUBMIT"]) ){
   $fp = fopen("data.txt", "a");
   fwrite($fp, $name."\t".$title."\t".$sentence."\t".$today."\n");
   header("Location:http://192.168.33.10:8000/index.php");
   exit;
 }
$fp = fopen("data.txt","r");
$dataArr = array();
while( $res = fgets($fp)){
  $tmp = explode("\t",$res);
  $arr = array(
    "name" => $tmp[0],
    "title" => $tmp[1],
    "sentence" => $tmp[2],
    "date"=> $tmp[3]
  );
  $dataArr[] = $arr;
}
 ?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>postform</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <div class="postform">
      <h2>投稿フォーム</h2>
      <form class="form" action="index.php"  onsubmit="return check()" method="post">
        <h3>名前</h3>
        <input type="text" name="name" id="name" value="">
        <h3>タイトル</h3>
        <input type="text" name="title" id="title" value="">
        <h3>本文</h3>
        <textarea class="honbun" name="sentence" id="body" rows="8" cols="80"></textarea>
        <br>
        <input class="input" type="submit" name="SUBMIT" value="投稿">
        <input type="reset" value="リセット">

      </form>
    </div>
    <div class="result">
      <h2>投稿</h2>

      <dl>
      <?php foreach($dataArr as $data): ?>
        <li>
          <div class="posts">
          <?php echo $data["name"];?>:<?php echo $data["title"]; ?>:<?php echo $data["date"]; ?>
          <br>
          <?php echo $data["sentence"]; ?>
          </div>
        </li>
      <?php endforeach; ?>
     </dl>
    </div>

  <script>
    function check(){
      let name = document.getElementById('name').value;
      let title = document.getElementById('title').value;
      let body = document.getElementById('body').value;
        if(document.getElementById('body').value==""){
        alert("本文を入力してください");
            return false;
        }else{
        return confirm("名前:"+name+"\n"+"メールアドレス:"+title+"\n"+"内容:"+body+"\n"+"以上の内容で投稿しますか？");
        }
    }
  </script>
  </body>
</html>
