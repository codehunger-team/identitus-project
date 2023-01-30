<script>
    $(document).ready(function() {
        var formData = $('#ajax-search-form').serialize();
        $('#domainsTable').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: "{{route('ajax.domainfiltering')}}",
                data: formData,
                cache: false,
                beforeSend: function() {
                    $('.preload-search').show();
                    $('.ajax-filtered-domains').hide();
                },
                success: function(data) {
                    $('.preload-search').hide();
                    $('.ajax-filtered-domains').show();
                },
                error: function(data) {
                    $('.preload-search').hide();
                    $('.ajax-filtered-domains').show();
                }
            },
            columns: [{
                    data: "domain",
                    name: "domain"
                },
                {
                    data: "monthly_lease",
                    name: "monthly_lease"
                },
                {
                    data: "pricing",
                    name: "pricing"
                },
                {
                    data: "options",
                    name: "options"
                },
            ]
        });
    });
    //uncheck all except domain with numerals
    $('input.numeralsonly').on('change', function() {
        $('input.numerals').not(this).prop('checked', false);
    });

    //uncheck domain with numerals only
    $('input.numerals').on('change', function() {
        $('input.numeralsonly').not(this).prop('checked', false);
    });
    $(document).ready(function() {
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
    $('#sbAjaxSearch').click(function() {
        $('#domainsTable').DataTable().clear().destroy();
        event.preventDefault();
        var formData = $('#ajax-search-form').serialize();
        $.ajax({
            type: 'POST',
            url: "{{route('ajax.domainfiltering')}}",
            data: formData,
            cache: false,
            beforeSend: function() {
                $('.preload-search').show();
                $('.ajax-filtered-domains').hide();
            },
            success: function(data) {
                $('.preload-search').hide();
                $('.ajax-filtered-domains').show();
            },
            error: function(data) {
                $('.preload-search').hide();
                $('.ajax-filtered-domains').show();
                sweetAlert("Oops...", data, "error");
            }
        });
    });
</script>