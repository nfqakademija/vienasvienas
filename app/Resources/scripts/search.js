/**
 * Created by aleksandr on 5/9/15.
 */

$( document ).ready(function() {
    var books = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/search/auto/?q=%QUERY',
            wildcard: '%QUERY'
        }
    });


    $('#books_search').typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
            limit: 5
        },
        {
            name: 'book-search',
            display: 'query',
            source: books,
            templates: {
                empty: '<div class="empty-message">Unable to find any books that match the current query</div>'
            }
        }).on('typeahead:selected', function(e, data) {
            $("#search-form").submit();
        });
});
