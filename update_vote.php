<?php
//將表單元件的值轉成php變數

if (isset($_REQUEST["VID"]))
{
    /*require_once 'testlog.php';
    $vID=htmlspecialchars($_REQUEST["VID"]);
    $vScore=htmlspecialchars($_REQUEST["VScore"]);
	$log = new Logging();
	$log->lfile('testlog-sql20171110.txt');
	$log->lwrite($vID);	$log->lwrite($vScore);
	$log->lclose();*/

    $dbconfig = array (
        'database' => 'web2017',
        'username' => 'madoo',
        'password' => '4aJu6Cwh4cPKQUuW',
        'host' => 'localhost',
        'port' => '',
        'driver' => 'mysql',
    );
    
    $dbconfig = $GLOBALS['dbconfig'];
	$dsn = $dbconfig['driver'].":host=".$dbconfig['host'].";dbname=".$dbconfig['database'];
	$pdo = new PDO($dsn, $dbconfig['username'],$dbconfig['password']);
    $pdo->query("set names utf8");
    
	$sql="UPDATE `vote_record` SET `VScore`=:VScore WHERE `VID`=:VID";
        
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':VID', $vID, PDO::PARAM_STR); 
    $pdoStatement->bindValue(':VScore', $vScore, PDO::PARAM_STR); 
    if (!$pdoStatement->execute()) {
        print_r($pdoStatement->errorInfo());
    }
}
?>