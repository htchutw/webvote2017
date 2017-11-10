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
session_start(); 
if(!isset($_SESSION["authenticated"])|| (time() - $_SESSION['authenticated'] > 6000 ))
{
    $redir = "login.php";
    header("Location: $redir");
    exit;
}
$sID=$_SESSION['SID'];
$sName=$_SESSION['SName'];
$sClass=$_SESSION['SClass'];
$votes=GetUserVotes($sID, $sClass);
$studentNum = count($votes); 


//從資料庫讀出使用者投票資料
function GetUserVotes($sID, $sClass) {
    $dbconfig = $GLOBALS['dbconfig'];
    $dsn = $dbconfig['driver'].":host=".$dbconfig['host'].";dbname=".$dbconfig['database'];
    $pdo = new PDO($dsn, $dbconfig['username'],$dbconfig['password']);
    $pdo->query("set names utf8");

    $sql = "SELECT VID, VScore, XID FROM vote_record WHERE SID = :SID AND SClass =:SClass ORDER BY XID DESC";
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':SID', $sID, PDO::PARAM_STR);
    $pdoStatement->bindValue(':SClass', $sClass, PDO::PARAM_STR);
    $ret = $pdoStatement->execute();
    $rowAll = $pdoStatement->fetchAll();
    if ($rowAll)
    {
        return $rowAll;
    }
    return NULL;
}
?>

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
  <link rel="stylesheet" href="css/quiz.css">
  
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <h2><span class="badge badge-pill badge-primary"><i class="fa fa-graduation-cap" ></i>資訊與科技期中網頁互評</span></h2>
        <h2><span class="badge badge-pill badge-info"><i class="fa fa-users" ></i>評審：<?php echo $sID?>(<?php echo $sName?>)</span></h2>
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <h3><a class="nav-link" href="logout.php"><span class="badge badge-pill badge-danger"><i class="fa fa-sign-out" aria-hidden="true"></i>登出投票系統</span></a></h3>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid"> 
<?php 
$voteNo = 0;
$rowMax = $studentNum/4;
for ($rowNo = 0; $rowNo <$rowMax && $voteNo < $studentNum; $rowNo++) {
    echo '<div class="row">';
    for ($colNo = 0; $colNo <4 && $voteNo < $studentNum; $colNo++, $voteNo++) {
        $curVote = $votes[voteNo];
        print'                   
        <div class="quiz col-sm-12 col-xs-12 col-md-6 col-lg-3">
            <form>
                <div class="alert alert-info compact">'.$curVote["XID"].'
                </div>
                <div class="form-group">
                    <a target="_blank" href="http://210.70.80.111/'.$curVote["XID"].'htchu/" class="alert alert-danger compact">網頁：點我</a>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="inlineCheckbox0" value="option1" checked> 0
                    </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="inlineCheckbox6" value="option2"> 6
                    </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="inlineCheckbox7" value="option3"> 7
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="inlineCheckbox8" value="option4"> 8
                    </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="inlineCheckbox9" value="option5"> 9
                    </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="inlineCheckbox10" value="option6"> 10
                    </label>
                </div>
            </form>
        </div>';
    }
    echo '<\div>';
}
?>
</div><!--class="container-fluid" -->


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>