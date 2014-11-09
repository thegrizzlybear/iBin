//Flot Moving Line Chart
var data = [];
var dataset;
var totalPoints = 100;
var updateInterval = 3000;
var now = new Date().getTime();

function GetData() {
    data.shift();

    while (data.length < totalPoints - 1) {
    
        var y = 0;
        var temp = [now += updateInterval, y];

        data.push(temp);
    }

    //data.push(data[data.length-1]);

/*  while (data.length >= totalPoints)
    {
        data.shift();
    }   
*/
    $.ajax({
        url: "./datagen/getLatestUpdate.php",
    })
    .done(function( msg ) {
        msg = msg.split(",");
        now += updateInterval;
        console.log(msg + "|" + now);

        var dbDate = new Date(msg[0]).getTime();
    data.push([(dbDate > now)?dbDate:now, (msg[1]!=0)?msg[1]:data[data.length-1][1]]);
    
    });
}

var options = {
    series: {
        lines: {
            show: true,
            lineWidth: 1.2,
            fill: true
        }
    },
    xaxis: {
        mode: "time",
        tickSize: [2, "second"],
        tickFormatter: function (v, axis) {
            var date = new Date(v);

            if (date.getSeconds() % 20 == 0) {
                var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
                var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
                var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();

                return hours + ":" + minutes + ":" + seconds;
            } else {
                return "";
            }
        },
        axisLabel: "Time",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10
    },
    yaxis: {        
        /*tickSize: 5,
        tickFormatter: function (v, axis) {
            //var factor = v<10? 10: (v <100? 0.1 : 0.05);
            if (v % 10 == 0) {
                return v;
            } else {
                return "";
            }
        },*/
        axisLabel: "Amount Wastage (Kg)",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 6
    },
    legend: {        
        margin: [2,2],
        backgroundColor: "#fff",
        labelBoxBorderColor: "#fff"
    },
    grid: {                
        backgroundColor: "#000000",
        tickColor: "#008040"
    }
};

$(document).ready(function () {
    //GetData();

    dataset = [
        { label: "Current Wastage(Kg)", data: data, color: "#00FF00" }
    ];

    //Fill past values if any into data[]
/*  $.ajax({
        type: "POST",
        url: "../../cs684_mod/datagen/getPastUpdates.php",
        data: { count: totalPoints-1 },
        dataType:"json",
    async: false
    })
    .done(function( msg ) {
        for(var i=msg.length-1 ; i>=0; i-=2)
            data.push([msg[i-1], msg[i]]);
    });*/
     GetData();
    $.plot($("#flot-line-chart-moving"), dataset, options);

    function update() {
        GetData();

        $.plot($("#flot-line-chart-moving"), dataset, options)
        setTimeout(update, updateInterval);
    }

    update();

    //populate the student count column
    $("#studentCount").attr("disabled", true) ;
    function updateStudCount(){
        $.ajax({
        url: "./datagen/getCurrentPeopleCount.php",
        })
        .done(function( msg ) {
            $("#studentCount").val(msg);
        });
    }

    setInterval(updateStudCount, updateInterval);

});
