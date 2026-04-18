<script>
(function() {
    var filterTimer = null;
    var currentPage = 1;

    function fetchTable(page) {
        page = page || 1;
        currentPage = page;

        var params = $('#filter-form').serializeArray();
        params.push({ name: 'page', value: page });

        var queryString = $.param(params);

        $('#table-wrapper').addClass('loading');

        $.ajax({
            url: window.location.pathname,
            type: 'GET',
            data: queryString,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                $('table tbody').replaceWith(res.html);
                $('#pagination-wrapper').html(res.pagination);
                bindPaginationClicks();
            },
            complete: function() {
                $('#table-wrapper').removeClass('loading');
            }
        });
    }

    function bindPaginationClicks() {
        $(document).off('click', '.pagination-ajax').on('click', '.pagination-ajax', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) fetchTable(page);
        });
    }

    // Realtime filter with debounce
    $(document).on('input change', '#filter-form input, #filter-form select', function() {
        clearTimeout(filterTimer);
        filterTimer = setTimeout(function() {
            fetchTable(1);
        }, 400);
    });

    // Prevent form submit (handled by AJAX)
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        fetchTable(1);
    });

    bindPaginationClicks();
})();
</script>
