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

    $sql = "SELECT VID, VScore, XID, XName FROM vote_record WHERE SID = :SID AND SClass =:SClass ORDER BY XID ASC";
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
        <h3><a class="nav-link" href="logout.php"><span class="badge badge-pill badge-danger"><i class="fa fa-sign-out" aria-hidden="true"></i>登出投票系統</span></a></h3>
    </nav>
    <div class="container-fluid"> 
<?php 
$voteNo = 0;
$rowMax = $studentNum/4;
for ($rowNo = 0; $rowNo <$rowMax && $voteNo < $studentNum; $rowNo++) {
    echo '<div class="row">';
    for ($colNo = 0; $colNo <4 && $voteNo < $studentNum; $colNo++, $voteNo++) {
        $curVote = $votes[$voteNo];
        $s0=$s5=$s6=$s7=$s8=$s9=$s10="";
        switch ($curVote["VScore"]) {
            case 0:
                $s0="checked";
                break;
            case 5:
                $s5="checked";
                break;
            case 6:
                $s6="checked";
                break;
            case 7:
                $s7="checked";
                break;
            case 8:
                $s8="checked";
                break;
            case 9:
                $s9="checked";
                break;
            case 10:
                $s10="checked";
                break;
        }
        $voteID = $curVote["VID"];
        print'                   
        <div class="quiz col-sm-12 col-xs-12 col-md-6 col-lg-3">
            <form>
                <div class="alert alert-info compact">'.$curVote["XID"].'('.$curVote["XName"].')
                </div>
                <div class="form-group">
                    <a target="_blank" href="http://210.70.80.111/'.$curVote["XID"].'/" class="alert alert-danger compact">網頁：點我</a>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="'.$voteID.'" value="0"'.$s0.'> 0
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="'.$voteID.'" value="6" '.$s6.'> 6
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="'.$voteID.'" value="7" '.$s7.'> 7
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="'.$voteID.'" value="8" '.$s8.'> 8
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="'.$voteID.'" value="9" '.$s9.'> 9
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="x10500000" id="'.$voteID.'" value="10"'.$s10.'> 10
                    </label>
                </div>
            </form>
        </div>';
    }
    echo '</div>';
}
?>
</div><!--class="container-fluid" -->

<script type="text/javascript">
var rr =  document.querySelectorAll('input[type="radio"]');
for (var i = 0; i < rr.length; i++)
{
    rr[i].addEventListener("change", handler, false);
}
function handler(event) {
    //alert('update_vote.php?VID='+this.id+'&VScore='+this.value);

    var oReq = new XMLHttpRequest();
    
    oReq.open('GET', 'update_vote.php?VID='+this.id+'&VScore='+this.value);
    /*oReq.onreadystatechange = function (aEvt) {
        if (oReq.readyState == 4) {
            if(oReq.status == 200)
                alert(oReq.responseText);
            else
                alert("Error loading page\n");
        }
    };*/
    //oReq.addEventListener("load", reqListener);
    oReq.send();
    /*xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_test.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200 ) {
            alert( xhr.readyState+'='+ xhr.responseText);
        }
        else if (xhr.status !== 200) {
            alert('Request failed.  Returned status of ' + xhr.status);
        }
    };
    xhr.send(encodeURI('SData=' + this.id));*/


}
function reqListener () {
  console.log(this.readyState);
  alert(this.readyState);
}


</script>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>