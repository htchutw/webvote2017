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
if(!isset($_GET["W"])){
    $redir = 'index.php';
    header("Location: $redir");
}    
$sClass = $_GET["W"];
$all=GetVoteStats($sClass);
$preXID = "XXXXX";
$voteCount = 0;
$voteScore = 0;
$arrCount = array();
$arrScore = array();
$arrXName = array();

foreach ($all as $row) {
    if ($preXID!=$row["XID"])
    {
        if ($voteCount > 0)
        {
            $arrCount[$preXID] = $voteCount;
            $arrScore[$preXID] = bcdiv($voteScore, $voteCount, 2);
            $voteCount = 0;
            $voteScore = 0;
        }
        else if ($preXID!="XXXXX")
        {
            $arrCount[$preXID] = 0;
            $arrScore[$preXID] = 0.0;
        }
        $preXID=$row["XID"];
        $arrXName[$preXID] = $row["XName"];
    }
    if ($row["VScore"] > 0)
    {
        $voteCount ++;
        $voteScore +=$row["VScore"];
    }
}

//從資料庫讀出使用者投票資料
function GetVoteStats($sClass) {
    $dbconfig = $GLOBALS['dbconfig'];
    $dsn = $dbconfig['driver'].":host=".$dbconfig['host'].";dbname=".$dbconfig['database'];
    $pdo = new PDO($dsn, $dbconfig['username'],$dbconfig['password']);
    $pdo->query("set names utf8");

    $sql = "SELECT VScore, XID, XName FROM vote_record WHERE SClass =:SClass ORDER BY XID ASC";
    $pdoStatement = $pdo->prepare($sql);
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
  <title>資訊與科技期中網頁互評結果</title>
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
        <h2><span class="badge badge-pill badge-success"><i class="fa fa-graduation-cap" ></i>資訊與科技期中投票統計</span></h2>
    </nav>
    <div class="container"> 
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">學號</th>
                        <th scope="col">姓名</th>
                        <th scope="col">投票數</th>
                        <th scope="col">平均分數</th>
                    </tr>
                </thead>
                <tbody>
<?php
foreach ($arrCount as $XID => $VCount)
{
    $VScore = $arrScore[$XID];
    $XName = $arrXName[$XID];
    
    print '
    <tr>
        <td>'.$XID.'</td>
        <td>'.$XName.'</td>
        <td>'.$VCount.'</td>
        <td>'.$VScore.'</td>
    </tr>
    ';
}
?>
                </tbody>
            </table>
        </div>
    </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>