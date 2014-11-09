<?php
    include('./Database.php');

    $date = date("Y-m-d");
    $time = date("Y-m-d H:i:s");

    //echo $time;

    $D =new DatabaseCon;
    $con = $D->connect();
    $D->selectDB('ibin',$con);

    //select the right time based on current time

    $datetime0 = new DateTime($time);
    $datetime1 = new DateTime($date.' '.'07:00:00');
    $datetime2 = new DateTime($date.' '.'10:00:00');

    $datetime3 = new DateTime($date.' '.'12:30:00');
    $datetime4 = new DateTime($date.' '.'14:00:00');

    $datetime5 = new DateTime($date.' '.'04:30:00');
    $datetime6 = new DateTime($date.' '.'18:00:00');


    $datetime7 = new DateTime($date.' '.'19:30:00');
    $datetime8 = new DateTime($date.' '.'22:00:00');
    

    if ( $datetime0 > $datetime1 && $datetime0 < $datetime2 ){
        $time ="'07:00:00' and '10:00:00'";
    }else if ( $datetime0 > $datetime3 && $datetime0 < $datetime4 ){
        $time ="'12:30:00' and '14:00:00'";
    }else if ( $datetime0 > $datetime5 && $datetime0 < $datetime6 ){
        $time ="'04:30:00' and '18:00:00'";
    }else if ( $datetime0 > $datetime7 && $datetime0 < $datetime8 ){
        $time ="'19:30:00' and '22:00:00'";
    }else{
        $time ="'00:00:00' and '23:59:59'";
    }
    
    $stmnt = "SELECT count(*) FROM student where DATE(ts)='".$date."' and TIME(ts) between ".$time;
    $result = $D->fireQuery($stmnt);


    //echo '<a href="./dbTest.php?date=2014-09-29">2014-09-29</a>';
    //echo "<p>".$date."<br />";
    while($row = mysql_fetch_array($result))
    {
        echo $row[0];
    }

?>
