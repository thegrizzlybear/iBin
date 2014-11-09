$(function() {

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '&lt;50',
            a: 100
        }, {
            y: '51 - 100',
            a: 75
        }, {
            y: '101 - 150',
            a: 50
        }, {
            y: '151 - 200',
            a: 71
        }, {
            y: '201 - 250',
            a: 50
        }, {
            y: '251 - 300',
            a: 75
        }, {
            y: '301 - 350',
            a: 75
        }, {
            y: '351 - 400',
            a: 75
        }, {
            y: '401 - 450',
            a: 100
        }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Series A'],
        horizontal: true,
        hideHover: 'auto',
        resize: true
    });

});
