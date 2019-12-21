if (typeof (STMListings) == 'undefined') {
    var STMListings = {};
}

(function ($) {
    "use strict";


    function Filter(form) {
        this.form = form;
		this.ajax_action = ($(this.form).data('action')) ? $(this.form).data('action'): 'listings-result';
        this.init();
    }

    Filter.prototype.init = function () {
        $(this.form).submit($.proxy(this.submit, this));
        this.getTarget().on('click', 'a.page-numbers', $.proxy(this.paginationClick, this));
    };

    Filter.prototype.submit = function (event) {
        event.preventDefault();


        var data = [],
            url = $(this.form).attr('action'),
            sign = url.indexOf('?') < 0 ? '?' : '&';

        $.each($(this.form).serializeArray(), function (i, field) {
            if (field.value != '') {
                data.push(field.name + '=' + field.value)
            }
        });

        url = url + sign + data.join('&');

        url = url.replace("min_price=Min", "min_price=0");
        url = url.replace("max_price=Max", "max_price=2000000");

        url = url.replace("min_price=الحد الأدنى", "min_price=0");
        url = url.replace("max_price=أقصى", "max_price=2000000");

        //specials order change
        var specials = $("input[name=featured_top_hidden]").val()
        if(specials){
            var loc = window.location.href
            var order = $(".stm-select-sorting select").val()
           url = loc+'&sort_order='+order
        }

        this.performAjax(url);
    };

    Filter.prototype.paginationClick = function (event) {
        event.preventDefault();
        var stmTarget = $(event.target).closest('a').attr('href');
        this.performAjax(stmTarget);
    };

    Filter.prototype.pushState = function (url) {
		//window.history.pushState('', '', decodeURI(url));
        var data = []
        var filterUrl = ["min_price", "max_price", "ca_location" ,"stm_lat", "stm_lng", "max_search_radius", "sort_order", "trp-form-language" ]  
        var urlObj = URLToArray(url);
        for(var prop in urlObj){
            //console.log(prop)
            if(filterUrl.indexOf(prop) == -1)
            data.push(prop + '=' + urlObj[prop])
        }
        url = $("form[data-trigger=filter-map]").attr('action')
        var sign = url.indexOf('?') < 0 ? '?' : '&';
        url = url + sign + data.join('&');
        window.history.pushState('', '', decodeURI(url));
	};

    Filter.prototype.performAjax = function (url) {
		$.ajax({
            url: url,
            dataType: 'json',
            context: this,
			data: 'ajax_action='+this.ajax_action,
            beforeSend: this.ajaxBefore,
            success: this.ajaxSuccess,
            complete: this.ajaxComplete
        });        
    };

    Filter.prototype.ajaxBefore = function () {
        this.getTarget().addClass('stm-loading');
        //buildUrl();
    };

    Filter.prototype.ajaxSuccess = function (res) {
        this.getTarget().html(res.html);
        this.disableOptions(res);
        if (res.url) {
        	this.pushState(res.url);
		}
    };

    Filter.prototype.ajaxComplete = function () {
        this.getTarget().removeClass('stm-loading');
    };

    Filter.prototype.disableOptions = function (res) {
        if (typeof res.options != 'undefined') {
            $.each(res.options, function (key, options) {
                $('select[name=' + key + '] > option', this.form).each(function () {
                    var slug = $(this).val();
                    if (options.hasOwnProperty(slug)) {
                        $(this).prop('disabled', options[slug].disabled);
                    }
                });
            });
        }
    };

    Filter.prototype.getTarget = function () {
        var target = $(this.form).data('target');
        if (!target) {
            target = '#listings-result';
        }
        return $(target);
    };

    STMListings.Filter = Filter;

    $(function () {
        $('form[data-trigger=filter]').each(function () {
            $(this).data('Filter', new Filter(this));
        });
    });



})(jQuery);


function URLToArray(url) {
    var request = {};
    var pairs = url.substring(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < pairs.length; i++) {
        if(!pairs[i])
            continue;
        var pair = pairs[i].split('=');
        request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
     }
     return request;
}