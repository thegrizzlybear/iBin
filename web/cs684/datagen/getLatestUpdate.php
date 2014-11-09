<?php
    include('./Database.php');

    $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date("Y-m-d");
    $time = isset($_REQUEST['time']) ? $_REQUEST['time'] : "Breakfast";

    $D =new DatabaseCon;
    $con = $D->connect();
    $D->selectDB('ibin',$con);   

    $stmnt = "SELECT * FROM waste order by ts DESC LIMIT 1";
    $result = $D->fireQuery($stmnt);


    //Get last inserted row with ts
    while($row = mysql_fetch_array($result))
	{
		echo $row['ts'].",".$row['weight'];
	}

	//echo "</p>";
	//echo "<h3>Query 1 (<150)</h3>";
    

?>
