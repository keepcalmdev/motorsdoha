(function($) {
    $(document).ready(function () {
        var copyText = '';

        $(".auto_select").each(function () {
            var width = $(this).val().length;
            $(this).attr('size', width);
        });

        $(".auto_select").on('hover', function(){
            copyText = $(this).val();
            this.focus();
            this.select();
        }, function () {
            $(this).val(copyText);
            this.blur();
        });

    });

})(jQuery);