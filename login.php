<?php
//DB
$GLOBALS['dbconfig'] = array (
    'database' => 'web2017',
    'username' => 'madoo',
    'password' => '4aJu6Cwh4cPKQUuW',
    'host' => 'localhost',
    'port' => '',
    'driver' => 'mysql',
    );
//2017/11/08
$msgError = "預設密碼是0000";
if(isset($_POST["SID"])){
    session_start();
    $sID = $_POST["SID"];
    $sCode = $_POST["SCode"];
    $UserData = CheckUser($sID, $sCode);
    if($UserData != NULL)
    {
        $_SESSION['authenticated'] = time();
        $_SESSION['SID'] = $sID;
        $_SESSION['SName'] = $UserData['SName'];
        $_SESSION['SClass'] = $UserData['SClass'];
        $redir = 'index.php';
        header("Location: $redir");
        exit;
    }
    else
        $msgError = "帳號或密碼錯誤";
}    
//從資料庫讀出使用者資料
function CheckUser($sID, $sCode) {
    $dbconfig = $GLOBALS['dbconfig'];
    $dsn = $dbconfig['driver'].":host=".$dbconfig['host'].";dbname=".$dbconfig['database'];
    $pdo = new PDO($dsn, $dbconfig['username'],$dbconfig['password']);
    $pdo->query("set names utf8");

    $sql = "SELECT SName, SClass FROM webpage_user WHERE SID = :SID AND SCode =:SCode";
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':SID', $sID, PDO::PARAM_STR);
    $pdoStatement->bindValue(':SCode', $sCode, PDO::PARAM_STR);
    $ret = $pdoStatement->execute();
    $row = $pdoStatement->fetch();
    if ($row)
    {
        return $row;
    }
    return NULL;
}
?>

<!doctype html>
<html lang="zh-Hant-TW">
  <head>
    <title>資訊與科技期中網頁互評</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!--Font Awesome CSS-->
    <link rel="stylesheet" href="css/font-awesome.min.css">    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/signin.css">
    
  </head>
  <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <h2><span class="badge badge-pill badge-primary"><i class="fa fa-graduation-cap" aria-hidden="true"></i>資訊與科技期中網頁互評</span></h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    <div class="container">                    
        <form class="form-signin" method="POST" action="login.php">
        <h3><span class="badge badge-info"><i class="fa fa-keyboard-o" aria-hidden="true"></i>用您的學號登入...</span></h3>
        <label for="inputEmail" class="sr-only">學號</label>
        <input name="SID" type="text" id="inputEmail" class="form-control" placeholder="10501001(學號)" required autofocus>
        <label for="inputPassword" class="sr-only">密碼(都是0000)</label>
        <input name="SCode" type="password" id="inputPassword" class="form-control" placeholder="0000(密碼)" required>
        <div class="checkbox">
            <label>
            <input type="checkbox" value="remember-me"> 記得我, <?php echo $msgError;?>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登入投票</button>
        </form>
                    
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>