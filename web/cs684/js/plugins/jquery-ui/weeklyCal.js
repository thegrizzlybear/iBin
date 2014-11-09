$("#datepicker").attr("disabled", true) ;
//$("#datepicker").val($.datepicker.formatDate('dd-mm-yy', now4));
$('#datepicker').datepicker({
	showAnim: "slide",
    dateFormat: 'yy-mm-dd',
    showOn: "button",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true,
    buttonText: "Select date",
    onSelect: function(formated) {
        var url = 'weekly.php?date='+$("#datepicker").val();
        //alert('Yo');
        $(location).attr('href',url);
    }
});