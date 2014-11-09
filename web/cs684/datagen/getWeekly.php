<?php
    include('./Database.php');

    $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date("Y-m-d");
    //$time = isset($_REQUEST['time']) ? $_REQUEST['time'] : "Breakfast";
 
    $cat1 = 0; $cat2 = 0; $cat3 = 0; $cat4 = 0;

    $D =new DatabaseCon;
    $con = $D->connect();
    $D->selectDB('ibin',$con);

    //select the right time based on $_REQUEST['time']
    
    $time1 ="'07:00:00' and '10:00:00'";
    
    $time2 ="'12:30:00' and '14:00:00'";

    $time3 ="'04:30:00' and '18:00:00'";

    $time4 ="'19:30:00' and '22:00:00'";


    $dow = array( date('Y-m-d', strtotime(' -6 days')), date('Y-m-d', strtotime(' -5 days')), date('Y-m-d', strtotime(' -4 days')),
                  date('Y-m-d', strtotime(' -3 days')), date('Y-m-d', strtotime(' -2 days')), date('Y-m-d', strtotime(' -1 day')), $date);

    $dowName = array(   date('l', strtotime(' -6 days')), date('l', strtotime(' -5 days')), date('l', strtotime(' -4 days')),
                        date('l', strtotime(' -3 days')), date('l', strtotime(' -2 days')), date('l', strtotime(' -1 day')), date('l'));


    $tot = array();

    for($x=0; $x<count($dow); $x++) {

        //echo $dow[$x];
        //echo "<br>";
    
        $stmnt = "SELECT max(weight) FROM waste where DATE(ts)='".$dow[$x]."' and TIME(ts) between ".$time1;
        $result = $D->fireQuery($stmnt);

        while($row = mysql_fetch_array($result))
        {
            $cat1 = $row[0];
            //echo $row[0];
        }

        $stmnt = "SELECT max(weight) FROM waste where DATE(ts)='".$dow[$x]."' and TIME(ts) between ".$time2;
        $result = $D->fireQuery($stmnt);

        while($row = mysql_fetch_array($result))
        {
            $cat2 = $row[0];
            //echo $row[0];
        }

        $stmnt = "SELECT max(weight) FROM waste where DATE(ts)='".$dow[$x]."' and TIME(ts) between ".$time3;
        $result = $D->fireQuery($stmnt);

        while($row = mysql_fetch_array($result))
        {
            $cat3 = $row[0];
            //echo $row[0];
        }

        $stmnt = "SELECT max(weight) FROM waste where DATE(ts)='".$dow[$x]."' and TIME(ts) between ".$time4;
        $result = $D->fireQuery($stmnt);

        while($row = mysql_fetch_array($result))
        {
            $cat4 = $row[0];
            //echo $row[0];
        }

        $total = $cat1+$cat2+$cat3+$cat4;
        array_push($tot, $total);
    }
?>

var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";;

$(function() {
    Morris.Line({
        element: 'morris-line-chart',
        data: [
            { y: '<?php echo $dow[0]; ?>', a: <?php echo $tot[0]; ?> },
            { y: '<?php echo $dow[1]; ?>', a: <?php echo $tot[1]; ?> },
            { y: '<?php echo $dow[2]; ?>', a: <?php echo $tot[2]; ?> },
            { y: '<?php echo $dow[3]; ?>', a: <?php echo $tot[3]; ?> },
            { y: '<?php echo $dow[4]; ?>', a: <?php echo $tot[4]; ?> },
            { y: '<?php echo $dow[5]; ?>', a: <?php echo $tot[5]; ?> },
            { y: '<?php echo $dow[6]; ?>', a: <?php echo $tot[6]; ?> }
        ],
        xkey: 'y',
        <!--xLabelFormat: function (x) { return weekday[ new Date(x).getDay() ]; },-->
        ykeys: ['a'],
        labels: ['Series A']
    });
});
