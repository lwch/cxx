$(function() {
    $('.jumbotron .btn').on('click', function() {
        $this = $(this);
        page.commit($this.attr('id'));
    });
    $('#refresh').click(function() {
        page.update();
    });
    $('#report').click(function() {
        report.show();
    });
    page.update();
});

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
                $('#group>.row>div>p>#'+k+'>span').text(v);
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
