$(document).ready(function () {
    $('#logout').on('click', function(e) {
        e.preventDefault();
        if(confirm('You wish to logout this session?'))
        {
            $.ajax({
                url: '../app/controls/HomeController.php'
            })
        }
    })
})