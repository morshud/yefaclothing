/* global $ */

(function () {
    function openMobileMenu() {
        $('#mobileMenu').removeClass('hidden').attr('aria-hidden', 'false');
        $('body').addClass('overflow-hidden');
    }

    function closeMobileMenu() {
        $('#mobileMenu').addClass('hidden').attr('aria-hidden', 'true');
        $('body').removeClass('overflow-hidden');
    }

    $(document).on('click', '[data-mobile-menu-open]', function () {
        openMobileMenu();
    });

    $(document).on('click', '[data-mobile-menu-close]', function () {
        closeMobileMenu();
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
            closeQuickView();
        }
    });

    $(document).on('click', '[data-mobile-dropdown-toggle]', function () {
        var $btn = $(this);
        var $panel = $btn.closest('div').find('[data-mobile-dropdown-panel]').first();
        $panel.toggleClass('hidden');
    });

    // Quick view modal (homepage)
    function openQuickView(product) {
        var $modal = $('#quickViewModal');
        if ($modal.length === 0) return;

        $modal.find('[data-qv-name]').text(product.name);
        $modal.find('[data-qv-price]').text(product.price);
        $modal.find('[data-qv-image]').attr('src', product.image).attr('alt', product.name);

        $modal.removeClass('hidden').attr('aria-hidden', 'false');
        $('body').addClass('overflow-hidden');
    }

    function closeQuickView() {
        var $modal = $('#quickViewModal');
        if ($modal.length === 0) return;

        $modal.addClass('hidden').attr('aria-hidden', 'true');
        $('body').removeClass('overflow-hidden');
    }

    // Expose for Escape handler
    window.closeQuickView = closeQuickView;

    $(document).on('click', '[data-qv-open]', function () {
        var $btn = $(this);
        var product = {
            name: $btn.attr('data-name') || '',
            price: $btn.attr('data-price') || '',
            image: $btn.attr('data-image') || '',
        };

        openQuickView(product);
    });

    $(document).on('click', '[data-qv-close]', function () {
        closeQuickView();
    });

    $(document).on('click', '[data-qv-backdrop]', function () {
        closeQuickView();
    });
})();
