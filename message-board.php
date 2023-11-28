<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>MessageBoard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        //新規投稿・編集登録用
        //$filename="mission_3-5.txt";
        if (!empty($_POST["str1"])&&!empty($_POST["str2"])&&!empty($_POST["password"])) {
            $name = $_POST["str1"];
            $comment = $_POST["str2"];
            $postedAt = date('Y年m月d日 H:i:s');
            $pw=$_POST["password"];
            $filename="MB1.txt";
            if(!empty($_POST["sign"])){
                $editN=$_POST["sign"];
                $lines=file($filename);
                $fp=fopen($filename,"w");
                foreach($lines as $line){
                    $editData=explode("<>",$line);
                    if($editData[0]==$editN){
                        fwrite($fp,"$editN<>$name<>$comment<>$postedAt<>$pw<>".PHP_EOL);
                    }else{
                        fwrite($fp,$line);
                    }
                }fclose($fp);
            }else{
                if (file_exists($filename)) {
                    $num = count(file($filename))+1;
                } else {
                    $num = 1;
                }
                $Data = $num."<>".$name."<>".$comment."<>".$postedAt."<>".$pw."<>";
                if($name&&$comment){
                    $fp = fopen($filename,"a");
                    fwrite($fp, $Data.PHP_EOL);
                    fclose($fp);
                 }    
            }
        }
        //削除用
        if(!empty($_POST["del"])){
            $dn=$_POST["del"];
            $filename="MB1.txt";
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $fp=fopen($filename,"w");
            for($i=0;$i<count($lines);$i++){
                $line=explode("<>",$lines[$i]);
                $postnum=$line[0];
                if($dn==$postnum&&$line[4]==$_POST["d-password"]){
                    unset($line[$dn-1]);
                    continue;
                }else{
                    fwrite($fp,$lines[$i].PHP_EOL);
                }
            }
            fclose($fp);
        }
        //編集用
        if(!empty($_POST["edit"])){
            $en=$_POST["edit"];
            $lines=file("MB1.txt");
            for($i=0;$i<count($lines);$i++){
                $line=explode("<>",$lines[$i]);
                if(($en==$line[0])&&($line[4]==$_POST["e-password"])){
                    $editname=$line[1];
                    $editcomment=$line[2];
                    $tnum=$line[4];
                }
            }
            //fclose($fp);
        }
        ?>
    <div class="input">
    <form action="" method="post">
        <h3 class="title">登録フォーム</h3>
        <div>名前</div><input type="text" name="str1" value="<?php if(isset($editname)){echo $editname;} ?>"><br>
        <div>コメント</div><input type="text" name="str2" value="<?php if(isset($editcomment)){echo $editcomment;} ?>"><br>
        <div>パスワード</div><input type="number" name="password"><br>
        <input type="submit" name="submit">
        <input type="hidden" name="sign" value="<?php if(!empty($en)&&$_POST["e-password"]==$tnum){echo $en;}?>"><br>
    </form>
    <form action="" method="post">
        <h3 class="title">削除</h3>
        <div>削除番号</div><input type="number" name="del"><br>
        <div>パスワード</div><input type="number" name="d-password"><br>
        <input type="submit" name="delete" value="削除">
    </form>
    <form action="" method="post">
        <h3 class="title">編集</h3>
        <div>編集対象番号</div><input type="text" name="edit"><br>
        <div>パスワード</div><input type="number" name="e-password"><br>
        <input type="submit" name="edition" value="編集"><br>
    </form>
    </div>
    <?php
    
        //表示用
        $filename="MB1.txt";
        if(!empty($filename) or file_exists($filename)){
            if(file_exists($filename)){
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                foreach((array)$lines as $line){
                    echo $line."<br>";
                }
                $count=1;
            }
        }
    ?>
</body>
</html>
