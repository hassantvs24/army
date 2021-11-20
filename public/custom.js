$(function () {
    $('#sidebarToggle').click(function() {
        $.ajax({
            type: "GET",
            url: $(this).data('url')
        });
    });
});




