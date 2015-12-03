
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

