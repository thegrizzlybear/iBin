<?php
    include('./Database.php');

    $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date("Y-m-d");
    $time = isset($_REQUEST['time']) ? $_REQUEST['time'] : "Breakfast";
    $cat1 = 0; $cat2 = 0; $cat3 = 0; $cat4 = 0; $cat5 = 0; $cat6 = 0;

    $D =new DatabaseCon;
    $con = $D->connect();
    $D->selectDB('ibin',$con);

    //select the right time based on $_REQUEST['time']
    if ($time == "Breakfast"){
        $time ="'07:00:00' and '10:00:00'";
    }else if ($time == "Lunch"){
        $time ="'12:30:00' and '14:00:00'";
    }else if ($time == "Tiffin"){
        $time ="'04:30:00' and '18:00:00'";
    }else{
        $time ="'19:30:00' and '22:00:00'";
    }
   
    /*
    $stmnt = "SELECT * FROM waste where DATE(ts)='".$date."' and TIME(ts) between '07:00:00' and '10:00:00'";
    $result = $D->fireQuery($stmnt);


    //echo '<a href="./dbTest.php?date=2014-09-29">2014-09-29</a>';
    //echo "<p>".$date."<br />";
    while($row = mysql_fetch_array($result))
	{
		//echo "Ts".$row['ts']."\t".$row['bin_id']."\t".$row['hostel_id']."\t".$row['weight']."<br />";
	}
    */

	//echo "</p>";
	//echo "<h3>Query 1 (<150)</h3>";
    $stmnt = "SELECT count(*) FROM waste where DATE(ts)='".$date."' and weight < 50 and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);

    //echo '<a href="./dbTest.php?date=2014-09-29">2014-09-29</a>';
    //echo "<p>".$date."<br />";
    while($row = mysql_fetch_array($result))
    {
        //echo "Count = ".$row[0]."<br />";
        $cat1 = $row[0];
    }

    //echo "</p>";
    //echo "<h3>Query 2 (150-200)</h3>"; 
    $stmnt = "SELECT count(*) FROM waste where DATE(ts)='".$date."' and weight between 50 and 150 and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);
    while($row = mysql_fetch_array($result))
    {
        //echo "Count = ".$row[0]."<br />";
        $cat2 = $row[0];
    }

    //echo "</p>";
    //echo "<h3>Query 3 (200-250)</h3>";  
    $stmnt = "SELECT count(*) FROM waste where DATE(ts)='".$date."' and weight between 150 and 250 and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);
    while($row = mysql_fetch_array($result))
    {
        //echo "Count = ".$row[0]."<br />";
        $cat3 = $row[0];
    }


    //echo "</p>";
    //echo "<h3>Query 4</h3>";
    $stmnt = "SELECT count(*) FROM waste where DATE(ts)='".$date."' and weight between 250 and 350 and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);
    while($row = mysql_fetch_array($result))
    {
        //echo "Count = ".$row[0]."<br />";
        $cat4 = $row[0];
    }


    //echo "</p>";
    //echo "<h3>Query 5</h3>";
    $stmnt = "SELECT count(*) FROM waste where DATE(ts)='".$date."' and weight between 350 and 450 and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);
    while($row = mysql_fetch_array($result))
    {
        //echo "Count = ".$row[0]."<br />";
        $cat5 = $row[0];
    }


    //echo "</p>";
    //echo "<h3>Query 4</h3>";
    $stmnt = "SELECT count(*) FROM waste where DATE(ts)='".$date."' and weight > 450 and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);
    while($row = mysql_fetch_array($result))
    {
        //echo "Count = ".$row[0]."<br />";
        $cat6 = $row[0];
    }

?>

$(function() {

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '<50',
            a: <?php echo $cat1; ?>
        }, {
            y: '51 - 150',
            a: <?php echo $cat2; ?>
        }, {
            y: '151 - 250',
            a: <?php echo $cat3; ?>
        }, {
            y: '251 - 350',
            a: <?php echo $cat4; ?>
        }, {
            y: '351 - 450',
            a: <?php echo $cat5; ?>
        }, {
            y: '>450',
            a: <?php echo $cat6; ?>
        }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['No of People'],
        horizontal: true,
        hideHover: 'auto',
        resize: true
    });

});
