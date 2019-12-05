jQuery(function($) {
    $(document).ready(function(){
        $('#mlb-insert-locations').click(open_locations_window);

        $(document).bind('DOMNodeInserted', function(e) {
            var element = e.target;

            $(element).find('.mlb_add_locations').click(open_locations_window);
        });
    });

    function open_locations_window() {
        tb_show('Insert Locations', '#TB_inline?inlineId=mlb-select-locations&width=753&height=500', '');

        var selectedlocations = [];

        $('.insert-all-locations').click(function(e) {
            e.preventDefault();

            cleanup();
            wp.media.editor.insert('[locations]');
        });

        $('.insert-selected-locations').unbind('click').click(function(e) {
            e.preventDefault();

            cleanup();
            wp.media.editor.insert('[locations ids="' + selectedlocations.join(',') + '"]');
        });

        $('[data-location-id]').unbind('click').click(function(e) {
            e.preventDefault();

            var locationsId = $(this).data('location-id');
            var index = $.inArray(locationsId, selectedlocations);

            if (index === -1) {
                selectedlocations.push(locationsId);
                $(this).addClass('selected');
            } else {
                selectedlocations.splice(index, 1);
                $(this).removeClass('selected');
            }

            if (selectedlocations.length) {
                $('.insert-selected-locations').show();
            } else {
                $('.insert-selected-locations').hide();
            }
        });
    }

    function cleanup() {
        $('.insert-all-locations').unbind('click');
        $('.insert-selected-locations').unbind('click');
        $('[data-location-id]').removeClass('selected').unbind('click');
    }
});