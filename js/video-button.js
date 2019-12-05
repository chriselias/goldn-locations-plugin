jQuery(function($) {
    $(document).ready(function(){
        $('#mlb-insert-video').click(open_video_window);

        $(document).bind('DOMNodeInserted', function(e) {
            var element = e.target;

            $(element).find('.mlb_add_video').click(open_video_window);
        });
    });

    function open_video_window() {
        tb_show('Insert Video', '#TB_inline?inlineId=mlb-select-video&width=753&height=500', '');

        $('.optio-tab-0').show();
        $('[href=".optio-tab-0"]').addClass('nav-tab-active');

        $('#video-tabs .nav-tab').off('click').on('click', function(e) {
            e.preventDefault();

            $('.video-tab').hide();
            $('.nav-tab-active').removeClass('nav-tab-active');
            $($(this).addClass('nav-tab-active').attr('href')).show();
        });

        $('.video-link').off('click').on('click', function(e) {
            e.preventDefault();
            cleanup();
            wp.media.editor.insert('[optio id="' + $(this).data('optio-id') + '"]');
        });

        $('.insert-all-videos').off('click').on('click', function(e) {
            e.preventDefault();
            cleanup();
            wp.media.editor.insert('[optio]');
        });

    }

    function cleanup() {
        $('.insert-all-videos').unbind('click');
        $('.video-link').unbind('click');
    }
});