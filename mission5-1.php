<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
    </body>
    <h1>好きな有名人</h1>
    <?php
        
        // DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード名';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
      
        //テーブル設定
        $sql = "CREATE TABLE IF NOT EXISTS mission5"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name varchar(32),"
        . "comment TEXT,"
        . "date DATETIME, "
        ."password TEXT"
        .");";
        $stmt = $pdo->query($sql);
        //削除機能
        if(isset($_POST["submit2"])){
            if(empty($_POST["num1"])){
                $error1="削除番号が入力されていません"."<br>";
            }
            elseif(empty($_POST["str5"])){
                $error2="パスワードが入力されていません"."<br>";
            }
            elseif(isset($_POST["num1"]) and isset($_POST["str5"])){
                $id = $_POST["num1"];//削除番号指定
                $password = $_POST["str5"];
                $sql = 'delete from mission5 where id=:id and password=:password';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);// 削除するidの値を指定
                $stmt->bindParam(':password', $password, PDO::PARAM_INT);//削除するidのpassward指定
                $stmt->execute();
            }
        }
        //編集確認機能
        if(isset($_POST["submit3"])){
            if(empty($_POST["num2"])){
                $error4="編集番号が入力されていません"."<br>";
            }
            elseif(empty($_POST["str6"])){
                $error5="パスワードが入力されていません"."<br>";
            }
            elseif(isset($_POST["num2"]) and isset($_POST["str6"])){
                $id = $_POST["num2"];//編集番号指定
                $password = $_POST["str6"];
                $sql = 'SELECT * FROM mission5 WHERE id=:id and password=:password ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);// 編集するidの値を指定
                $stmt->bindParam(':password', $password, PDO::PARAM_INT);//編集するidのpassward指定
                $stmt->execute();                             // SQLを実行する。
                $results = $stmt->fetchAll(); 
                foreach ($results as $row){
                    $a = $row['id'];//idを取り出す
                    $b = $row['name'];//名前を取り出す
                    $c = $row['comment'];//コメントを取り出す
                    $d = $row["password"];
                }
            }
        }
        //編集実行機能
        if(isset($_POST["submit1"])){
            if(empty($_POST["str1"])){
                    $error7="名前が入力されていません"."<br>";
                }
            elseif(empty($_POST["str2"])){
                $error8="コメントが入力されていません"."<br>";
            }
            elseif(empty($_POST["str4"])){
                $error9="パスワードが入力されていません"."<br>";
            }
            elseif(!empty($_POST["str3"])){
                $id = $_POST["str3"]; //編集番号指定
                $name = $_POST["str1"];//編集する内容
                $comment = $_POST["str2"]; //編集する内容
                $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=now() WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);//編集する内容を指定
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);//編集する内容を指定
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);// 編集するidの値を指定
                $stmt->execute();
                $hensyutext="名前：".$_POST["str1"]."<br>"."コメント：".$_POST["str2"]."<br>"."編集内容を受け取りました"."<br>";
            }
            //新規投稿機能
            elseif(isset($_POST["str1"]) and isset($_POST["str2"]) and isset($_POST["str4"])){
                $stmt = $pdo->query($sql);
                $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, date, password) VALUES (:name, :comment, now(), :password)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                $name = $_POST["str1"];
                $comment = $_POST["str2"]; 
                $password = $_POST["str4"];
                $sql -> execute();
                $sinkitext="名前：".$_POST["str1"]."<br>"."コメント：".$_POST["str2"]."<br>"."送信内容を受け取りました"."<br>";
            }
        }
        ?> 
        
        <!--投稿フォーム-->
        <strong>【投稿フォーム】</strong> <br>
        <form action="" method="post">
            名前：<input type="text" name="str1" placeholder="名前" value="<?php if(!empty($b)){echo $b;}?>"><br>
            コメント：<br> <textarea name="str2" rows=4 cols=25 placeholder="コメント" ><?php if(!empty($c)){echo $c;}?></textarea><br>
            パスワード：<input type="password" name= "str4"placeholder="パスワード" value="<?php if(!empty($d)){echo $d;}?>"><br>
            <input type="hidden" name="str3" value="<?php if(!empty($a)){echo $a;}?>">
            <input type="submit" name="submit1">
        </form>
        <!--削除フォーム-->
        <strong>【削除フォーム】</strong> <br>
        <form action="" method="post">
            削除番号：<input type="number" name="num1" placeholder="削除番号"><br>
            パスワード：<input type="password" name= "str5"placeholder="パスワード"><br>
            <input type="submit" name="submit2"value="削除">
        </form>
        <!--編集フォーム-->
        <strong>【編集フォーム】</strong> <br>
        <form action="" method="post">
            編集番号：<input type="number" name="num2" placeholder="編集番号"><br>
            パスワード：<input type="password" name= "str6"placeholder="パスワード"><br>
            <input type="submit" name="submit3"value="編集">
        </form>
        
     
        <h2>実行内容</h2>
    <hr>
    <br>
    
    <?php
        //エラー文、投稿内容、編集内容表示機能
        if(isset($error1)){
            echo $error1;
        }
        elseif(isset($error2)){
            echo $error2;
        }
        elseif(isset($error3)){
            echo $error3;
        }
        elseif(isset($error4)){
            echo $error4;
        }
        elseif(isset($error5)){
            echo $error5;
        }
        elseif(isset($error6)){
            echo $error6;
        }
        elseif(isset($error7)){
            echo $error7;
        }
        elseif(isset($error8)){
            echo $error8;
        }
        elseif(isset($error9)){
            echo $error9;
        }
        elseif(isset($hensyutext)){
            echo $hensyutext;
        }
        elseif(isset($sinkitext)){
            echo $sinkitext;
        }
    ?>
    <br>
    <hr>
    <h2>投稿一覧</h2>
    <?php
        //投稿内容表示
        $sql = 'SELECT * FROM mission5 ';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
            echo "<hr>";
        }
    ?>
    </body>
</html>
    