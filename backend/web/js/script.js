jQuery(document).ready(function ($) {
    $('#author-search').keyup(function () {
        $.ajax({
            type: 'get',
            url: 'find-author',
            data: {
                name: $(this).val()
            }
        }).done(function (res) {
            $('#authors').html(res);
            $('#authors').show();
        });
    });

    $('#authors').on('click', '.author', function () {
        var id = $(this).data('author-id');
        var value = $('#books-author_ids').val();
        if (value.indexOf('|' + id + '|') === -1) {
            $('#added-authors').append('<div data-author-id="' + id + '" class="added-author">' + $(this).text() + ' <span class="delete-author">X</span></div>');
            $('#books-author_ids').val(value + id + '|');
        }
        $('#authors').empty().hide();
        $('#author-search').val('');
    });

    $('#added-authors').on('click', '.delete-author', function () {
        var parent = $(this).parent('.added-author');
        var id = parent.data('author-id');
        $('#books-author_ids').val($('#books-author_ids').val().replace("|" + id + "|", '|'));
        parent.remove();
    });
});