<script>
    //uncheck all except domain with numerals
    $('input.numeralsonly').on('change', function () {
        $('input.numerals').not(this).prop('checked', false);
    });

    //uncheck domain with numerals only
    $('input.numerals').on('change', function () {
        $('input.numeralsonly').not(this).prop('checked', false);
    });
    $(document).ready(function () {
        const $charTo = $('.char_to');
        const $value = $('#char_slider');
        const $priceTo = $('.price_to');
        const $priceValue = $('#price_slider');
        const $monthlyPriceTo = $('.monthly_price_to');
        const $monthlyPriceValue = $('#monthly_price_slider');

        $value.val('63'); // set the charcter default value to zero
        $priceValue.val('20000'); // set the price defalut value
        $monthlyPriceValue.val('20000'); // set the price defalut value


        $value.on('input change', () => {
            $('.char_to').val($value.val());
            if ($value.val() == 0) {
                $charTo.val('');
            }
        });

        $monthlyPriceValue.on('input change', () => {
            priceCount = $("#monthly_price_slider").val();
            if (priceCount >= 17000) {
                $monthlyPriceTo.val('');
            } else {
                $monthlyPriceTo.val($monthlyPriceValue.val());

            }
        });

        $priceValue.on('input change', () => {
            priceCount = $("#price_slider").val();
            if (priceCount >= 17000) {
                $priceTo.val('');
            } else {
                $priceTo.val($priceValue.val());

            }
        });
    });

    $("#buttonAjaxFilter").on('click', function () {
        submitAjaxSearch();
    });

    $(".keyword-placement").on('change', function () {
        submitAjaxSearch();
    });

    $(".search-input").on('keyup', function () {
        submitAjaxSearch();
    });

    $(".price-range").on('change', function () {
        submitAjaxSearch();
    });

    $(".monthly-price-range").on('change', function(){
        submitAjaxSearch();
    });

    $(".character-length").on('change', function () {
        submitAjaxSearch();
    });

    $(".category").on('change', function () {
        submitAjaxSearch();
    });

    $(".any-tld").on('change', function () {
        submitAjaxSearch();
    });

    $(".age").on('change', function () {
        submitAjaxSearch();
    });

    function submitAjaxSearch() {
        $("#ajax-search-form").trigger('submit');
    }
    var ajaxFilterDomains = $("#ajax-search-form");

    ajaxFilterDomains.submit(function (event) {

        console.log('form submitted')

        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('ajax.domainfiltering')}}",
            data: formData,
            cache: false,
            beforeSend: function () {
                $('.preload-search').show();
                $('#ajax-filtered-domains').hide();
            },
            success: function (data) {
                $('.preload-search').hide();
                $('#ajax-filtered-domains').show();
                $('#ajax-filtered-domains').html(data);
            },
            error: function (data) {

                $('.preload-search').hide();
                $('#ajax-filtered-domains').show();
                sweetAlert("Oops...", data, "error");

            }
        });

        return false;
    });

</script>