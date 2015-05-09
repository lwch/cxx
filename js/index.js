$(function() {
    $('.jumbotron .btn').on('click', function() {
        $this = $(this);
        page.commit($this.attr('id'));
    });
});

var page = {
    commit: function(id) {
        $.ajax({
            url: '/api/commit.php',
            method: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                id: id
            }
        }).success(function(data) {
            if (data.stat == 0)
                page.update();
        });
    },
    update: function() {
        $.ajax({
            url: '/api/fetch.php',
            method: 'GET',
            cache: false,
            dataType: 'json'
        }).success(function(data) {
            $.each(data, function(k, v) {
                $('#group>#'+k+'>span').text(v);
            });
        });
    }
};
