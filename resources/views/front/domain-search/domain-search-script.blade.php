<script>
    $(document).ready(function() {
        datatable();
    });

    $('#sbAjaxSearch').click(function() {
        datatable();
    });

    function datatable() {
        $("#domainsTable").dataTable().fnDestroy();
        var filtersData = {};
        var formData = $('#ajax-search-form').serializeArray().map(function(x) {
            filtersData[x.name] = x.value;
        });
        $('#domainsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: "{{route('ajax.domainfiltering')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    filters: filtersData,
                },
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
    }
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
</script>