<?php
    include('./Database.php');

    $time = date('Y-m-d H:i:s');
    $n    = isset($_REQUEST['count']) ? $_REQUEST['count'] : 10;

    $D =new DatabaseCon;
    $con = $D->connect();
    $D->selectDB('ibin',$con);   

    $stmnt = "SELECT * FROM waste WHERE ts<'".$time."' ORDER BY ts DESC LIMIT ".$n;
    $result = $D->fireQuery($stmnt);

    //Get last inserted row with ts
    $ret = array();
    while($row = mysql_fetch_array($result))
	{
		//echo $row['ts'].",".$row['weight'];
        array_push($ret, $row['ts'], $row['weight'] );
	}

    //array_push($ret, 1, $n);
    //$ret = array_reverse($ret);

    echo json_encode($ret);

?>
