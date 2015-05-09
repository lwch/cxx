$(function() {
    $('.jumbotron .btn').on('click', function() {
        $this = $(this);
        page.commit($this.attr('id'));
    });
    $('#refresh').click(function() {
        page.update();
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
