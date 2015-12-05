
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

    $('#filter-date-from, #filter-date-to, #report-modal-date').datepicker({
        format: "dd.mm.yyyy",
        weekStart: 1,
        autoclose: true,
        todayHighlight: true
    });

    $('#filter-user').selectpicker();

    $('#filter-date-from, #filter-date-to, #filter-user, #filter-issue').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#report-modal').modal({
        'show': false
    });

});

function reportDelete(id) {
    if (window.confirm('Do you want delete report?')) {
        $.ajax({
            url: '/report-ajax/' + id,
            type: 'DELETE',
            dataType: 'json'
        }).done(function (result) {
            location.reload();
        }).fail(function (err) {

        });
    }
}

var ReportDialog = {};

ReportDialog.create = function () {
    var now = new Date();
    var date =
        ((now.getDate() < 10) ? "0" : "") + now.getDate() + "."
        + ((now.getMonth() < 9) ? "0" : "") + (now.getMonth() + 1) + "."
        + now.getFullYear();
    ReportDialog.show({
        "date": date,
        "complete": 100
    });
};

ReportDialog.edit = function (id) {
    $.ajax({
        url: "/report-ajax/" + id,
        type: "GET",
        dataType: "json",
        cache: false
    }).done(function (result) {
        ReportDialog.show(result.result);
    }).fail(function (err) {

    });
};

ReportDialog.hide = function () {
    $('#report-modal').modal('hide');
};

ReportDialog.showLoading = function () {
    $('#report-modal-loading').removeClass('hide');
};

ReportDialog.showSuccess = function () {
    $('#report-modal-success').removeClass('hide');
};

ReportDialog.hideLoading = function () {
    $('#report-modal-loading').addClass('hide');
};

ReportDialog.hideSuccess = function () {
    $('#report-modal-success').addClass('hide');
};

ReportDialog.show = function (data) {

    ReportDialog.hideLoading();
    ReportDialog.hideSuccess();

    $('#report-modal-id').val(data['id'] || "");
    $('#report-modal-date').val(data['date'] || "");
    $('#report-modal-issue-id').val(data['issueId'] || "");
    $('#report-modal-issue-text').val(data['issueText'] || "");

    var spentTimeH = '', spentTimeM = '';
    if (typeof data['spentTime'] !== 'undefined') {
        var spentTime = parseInt(data['spentTime']);
        if (isFinite(spentTime)) {
            spentTimeH = Math.floor(spentTime / 60);
            spentTimeM = spentTime % 60;
        }
    }
    $('#report-modal-spent-time').val(spentTimeH);
    $('#report-modal-spent-time-min').val(spentTimeM);

    var estimatedTimeH = '', estimatedTimeM = '';
    if (typeof data['estimatedTime'] !== 'undefined') {
        var estimatedTime = parseInt(data['estimatedTime']);
        if (isFinite(estimatedTime)) {
            estimatedTimeH = Math.floor(estimatedTime / 60);
            estimatedTimeM = estimatedTime % 60;
        }
    }
    $('#report-modal-estimated-time').val(estimatedTimeH);
    $('#report-modal-estimated-time-min').val(estimatedTimeM);

    var complete = '';
    if (typeof data['complete'] !== 'undefined') {
        var completeTmp = parseInt(data['complete']);
        if (isFinite(completeTmp)) {
            complete = completeTmp;
        }
    }
    $('#report-modal-complete').val(complete);

    $('#report-modal').modal('show');

};

ReportDialog.save = function () {

    var $reportId = $('#report-modal-id');
    var $reportDate = $('#report-modal-date');
    var $reportIssueId = $('#report-modal-issue-id');
    var $reportIssueText = $('#report-modal-issue-text');
    var $reportSpentTimeH = $('#report-modal-spent-time');
    var $reportSpentTimeM = $('#report-modal-spent-time-min');
    var $reportEstimatedTimeH = $('#report-modal-estimated-time');
    var $reportEstimatedTimeM = $('#report-modal-estimated-time-min');
    var $reportComplete = $('#report-modal-complete');

    //if ($reportDate.val() == "" || !(/^\d{1,2}.\d{1,2}.\d{4}$/).test($reportDate.val().replace(/\s/g, ''))) {
    //    alert('Invalid format of date.');
    //}

    var data = {};
    data['date'] = $reportDate.val();
    data['issueId'] = $reportIssueId.val();
    data['issueText'] = $reportIssueText.val();

    var spentTime = 0;
    var spentTimeH = parseInt($reportSpentTimeH.val());
    var spentTimeM = parseInt($reportSpentTimeM.val());
    if (isFinite(spentTimeH)) {
        spentTime += spentTimeH * 60;
    }
    if (isFinite(spentTimeM)) {
        spentTime += spentTimeM;
    }
    data['spentTime'] = spentTime;

    var estimatedTime = 0;
    var estimatedTimeH = parseInt($reportEstimatedTimeH.val());
    var estimatedTimeM = parseInt($reportEstimatedTimeM.val());
    if (isFinite(estimatedTimeH)) {
        estimatedTime += estimatedTimeH * 60;
    }
    if (isFinite(estimatedTimeM)) {
        estimatedTime += estimatedTimeM;
    }
    data['estimatedTime'] = estimatedTime;

    var complete = 0;
    var completeTmp = parseInt($reportComplete.val());
    if (isFinite(completeTmp)) {
        complete = completeTmp;
    }
    data['complete'] = complete;

    var url = '/report-ajax';
    if ($reportId.val() != '') {
        url += '/' + $reportId.val();
    }

    ReportDialog.showLoading();

    $.ajax({
        url: '/report-ajax' + ($reportId.val() != '' ? '/' + $reportId.val() : ''),
        type: ($reportId.val() != '' ? 'PUT' : 'POST'),
        contentType: 'application/json; charset=utf-8',
        data: JSON.stringify(data),
        dataType: 'json'
    }).done(function (result) {
        ReportDialog.hideLoading();
        ReportDialog.showSuccess();
        setTimeout(function () {
            location.reload();
        }, 250);
    }).fail(function (err) {
        console.log(err);
    });

};
