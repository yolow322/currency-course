google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(drawCurrencyChart);

function errorResponse(data, input) {
    let responseText = JSON.parse(data.responseText);
    $('#submission-status').html("<p class='alert alert-danger' role='alert'>" + responseText.message + "</p>").fadeIn('slow');
    setTimeout("$('#submission-status').fadeOut('slow');", 4000);
}

function successResponse(data) {
    $('#submission-status').html("<p class='alert alert-success' role='alert'>" + data.message + "</p>").fadeIn('slow');
    setTimeout("$('#submission-status').fadeOut('slow');", 4000);
}

function generateTable(data) {
    let rows = "<tr>";
    $('#tbody').empty();
    $.each(data, function (key, value) {
        rows += "<td>" + value.calendar_date + "</td>" +
            "<td>" + value.last_prediction_date + "</td>" +
            "<td>" + value.valute_id + "</td>" +
            "<td>" + value.name + "</td>" +
            "<td>" + value.value + "</td>" +
            "<td>" + value.valute_nominal + "</td>" +
            "<td>" + value.char_code + "</tr></td>";
    });
    rows += "</tr>";
    $('#tbody').append(rows);
}

function loadCurrencyData(CurrencyName) {
    let dateFrom = $('#date_from').val();
    let dateTo = $('#date_to').val();
    let selectedCurrencyCode = $('#currency_code').val();
    let tempTitle = CurrencyName;
    $.ajax({
        url: '/home/create-currency-chart',
        method: 'get',
        dataType: 'json',
        data: {
            from_date: dateFrom,
            to_date: dateTo,
            char_code: selectedCurrencyCode
        },
        success: function (data) {
            drawCurrencyChart(data, tempTitle);
        },
        error: function (data) {
            errorResponse(data);
        }
    });
}

function drawCurrencyChart(chartData, chartMainTitle) {
    let jsonData = chartData;
    let data = new google.visualization.DataTable();
    data.addColumn('date', 'Дата');
    data.addColumn('number', 'Курс ЦБ');
    $.each(jsonData, function (i, jsonData) {
        let calendarDate = jsonData.calendar_date;
        let currencyValue = parseFloat($.trim(jsonData.currency_value));
        data.addRows([[new Date(calendarDate), currencyValue]]);
    });
    let options = {
        title: chartMainTitle,
        explorer: {
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 16.0
        },
        hAxis: {
            title: 'Дата',
            format: 'dd/MM/yy'
        },
        vAxis: {
            title: 'Курс ЦБ'
        },
        pointSize: 2
    };
    let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

$(document).ready(function () {
    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd'
    });

    $(function () {
        $("#date").datepicker();
        $("#date_from").datepicker();
        $("#date_to").datepicker();
    });

    $('#refresh').click(function () {
        let date = $('#date').val();
        $.ajax({
            url: '/home/refresh-database',
            method: 'post',
            dataType: 'json',
            data: {
                date: date
            },
            success: function (data) {
                successResponse(data);
            },
            error: function (data) {
                errorResponse(data);
            }
        });
    });

    $('#find').click(function () {
        let date = $('#date').val();
        $.ajax({
            url: '/home/show-currencies',
            method: 'get',
            dataType: 'json',
            data: {
                date: date
            },
            success: function (data) {
                generateTable(data)
            },
            error: function (data) {
                errorResponse(data);
            }
        });
    });

    $('#create_chart').click(function () {
        let selectedCurrencyName = $('#currency_code option:selected').text();
        loadCurrencyData(selectedCurrencyName);
    });
});