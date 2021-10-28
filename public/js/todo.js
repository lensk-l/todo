(function($) {
    'use strict';
    $(function() {
        const todoListItem = $('.todo-list');

        todoListItem.on('change', '.checkbox', function() {
            if ($(this).attr('checked')) {
                $(this).removeAttr('checked');
            } else {
                $(this).attr('checked', 'checked');
            }

            $(this).closest("li").toggleClass('completed');

        });

    });
})(jQuery);


