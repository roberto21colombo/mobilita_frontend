var today = new Date();
var endDate = today.getFullYear()+"."+(today.getMonth()+1)+"/"+(today.getDate()-1);
$(function(){
    $('.datepicker').datepicker({
        startDate: "2013-01-01",
        endDate: endDate,
        format: "yyyy-mm-dd",
        language: "it",
        weekStart: 1
    });
});


