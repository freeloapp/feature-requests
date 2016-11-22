function generateUUID() {
    var d = new Date().getTime();
    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now(); //use high-precision timer if available
    }

    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}


jQuery(document).ready(function ($) {

    if (typeof Cookies.get('user') === 'undefined') {
        Cookies.set("user", generateUUID(), {expires: 5000});
    }

    $('button').click(function () {

        var id = $(this).parent().data("id");
        var element = '#rating-' + id;

        var myrating = $(element).data("myrating");
        var vote = $(this).data("vote");

        var likes;

        $(element + ' button').removeClass('active');

        if (myrating == vote) {
            $(element).data("myrating", 0);
            likes = parseInt($(this).data('count'));
            likes--;
            $(this).data('count', likes);
            $(this).find('.likes').text(likes);
            $(this).blur();
            vote = 0;
        }
        else {
            $(this).addClass('active');

            likes = parseInt($(this).find('.likes').text());
            likes++;
            $(this).find('.likes').text(likes);
            $(this).data('count', likes);

            // druhy tlacitko ponizit
            if (myrating != 0) {
                if (myrating == 1) {
                    likes = parseInt($(element + ' button.like .likes').text());
                    likes--;
                    $(element + ' button.like').data('count', likes);
                    $(element + ' button.like').find('.likes').text(likes);
                }
                else {
                    likes = parseInt($(element + ' button.dislike .likes').text());
                    likes--;
                    $(element + ' button.dislike').data('count', likes);
                    $(element + ' button.dislike').find('.likes').text(likes);
                }
            }

            $(element).data("myrating", vote);
        }

        // poslat na server

        $.ajax({
            method: "POST",
            url: "save.php",
            data: {id: id, vote: vote} // , cookie: Cookies.get("user")
        });

    });

});