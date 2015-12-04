
// renew session every 5 minutes

setInterval(function () {
    $.ajax({
        'type': 'post',
        'url': '/keep-alive/',
        'dataType': 'json'
    }).done(function (result) {
        //console.log(result);
    }).fail(function (err) {
    });
}, 5*60*1000);

$(function () {

    $('#filter-date-from, #filter-date-to').datepicker({
        format: "dd.mm.yyyy",
        weekStart: 1,
        autoclose: true,
        todayHighlight: true
    });

    $('#filter-user').selectpicker();

    $('#filter-date-from, #filter-date-to, #filter-user, #filter-issue').on('change', function () {
        $(this).closest('form').submit();
    });

});