$(function() {
    $('.jumbotron .btn').on('click', function() {
        $this = $(this);
        $.ajax({
            url: '/api/commit.php',
            method: 'POST',
            cache: false,
            data: {
                id: $this.attr('id')
            }
        });
    });
});
