$(function() {
    $('.jumbotron .btn').on('click', function() {
        $this = $(this);
        page.commit($this.attr('id'));
    });
    $('#refresh').click(page.update);
    $('#report').click(report.show);
    $('#cartogram').click(cartogram.show);
    page.update();
});

var common = {
    id2show: function(id) {
        console.log($('#group>.row>div>p>#'+id+'>#name').text());
        return $('#group>.row>div>p>#'+id+'>#name').text();
    }
};

var page = {
    commit: function(id) {
        $.ajax({
            url: 'http://cxx.coding.io/api/commit.php',
            method: 'GET',
            cache: false,
            dataType: 'jsonp',
            data: {
                id: id
            }
        }).success(page.update);
    },
    update: function() {
        $.ajax({
            url: 'http://cxx.coding.io/api/fetch.php',
            method: 'GET',
            cache: false,
            dataType: 'jsonp'
        }).success(function(data) {
            $.each(data, function(k, v) {
                $('#group>.row>div>p>#'+k+'>#cnt').text(v);
            });
        });
    }
};

var report = {
    show: function() {
        $.ajax({
            url: 'http://cxx.coding.io/api/info.php',
            method: 'GET',
            cache: false,
            dataType: 'jsonp'
        }).success(function(data) {
            $('#md-report table>tbody').empty();
            $.each(data.data, function(k, v) {
                $('#md-report table>tbody').append($('<tr><td>'+k+'</td><td>'+v+'</td></tr>'));
            });
            $('#md-report table>tbody').append($('<tr><th>总数</th><th>'+data.total+'</th></tr>'));
            $('#md-report').modal();
        });
    }
};

var cartogram = {
    show: function() {
        $.ajax({
            url: 'http://cxx.coding.io/api/fetch.php',
            method: 'GET',
            cache: false,
            dataType: 'jsonp'
        }).success(function(data) {
            var input = [];
            var i = 0;
            $.each(data, function(k, v) {
                input[i++] = [common.id2show(k), parseInt(v)];
            });
            console.log(input);
            $('#md-cartogram #container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: '统计图'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: '人数：',
                    data: input
                }]
            });
            $('#md-cartogram').modal();
        });
    }
};
