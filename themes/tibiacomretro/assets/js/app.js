(function($, window, document, undefined) {
    var config =
    {
        forum: {
            highlightGoto: true
        }
    };


    $(document).ready(function() {

        //
        //

        if (config.forum.highlightGoto)
        {
            var index = window.location.hash;

            if (index !== undefined)
            {
                index = index.replace('#', '');

                var $post   = $('a[name="' + index + '"]').closest('.forum-post'),
                    $footer = $post.next('.forum-post-footer');

                $post.addClass('highlight');
                $footer.addClass('highlight');

                setTimeout(function()
                {
                    $post.removeClass('highlight');
                    $footer.removeClass('highlight');
                }, 3500);
            }
        }

    });
})(jQuery, window, document);