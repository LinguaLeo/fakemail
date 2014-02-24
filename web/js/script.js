(function () {
    var $switchViewContainer = $('[data-container-switch-view]');

    $(document).on('click', '[data-switch-view]', function(e) {
        var viewMode = $(e.target).attr('data-switch-view');
        $switchViewContainer
            .removeClass('switch-view-html switch-view-text switch-view-source')
            .addClass('switch-view-' + viewMode);
    });
})();