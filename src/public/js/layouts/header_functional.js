// 検索機能
$(function () {
    searchWord = function () {
        var searchText = $(this).val();

        $('.item-card').each(function () {
            var targetText = $(this).text();

            const keywordLower = targetText.toLowerCase().indexOf(searchText)
            const keywordUpper = targetText.toUpperCase().indexOf(searchText)

            if (keywordLower != -1 || keywordUpper != -1) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });
    }

    $('#search-text').on('input', searchWord);
});