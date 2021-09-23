<div id="ds-clickwrap"></div>
<script src="https://demo.docusign.net/clickapi/sdk/latest/docusign-click.js"></script>
<script>
    let mustAgree = false;
    docuSignClick.Clickwrap.render({
        environment: "{{$clickwrap['environment']}}",
        accountId: "{{$clickwrap['accountId']}}",
        clickwrapId: "{{$clickwrap['clickwrapId']}}",
        clientUserId: "{{$clickwrap['clientUserId']}}",
        // Called when the user will be presented with an agreement
        onMustAgree: function (agreementData) {
            // Set a local variable if needing to distinguish new agreements
            mustAgree = true;
        },
        // Called when the user has previously agreed OR has just successfully completed the agreement AND response has been successfully stored
        onAgreed: function (agreementData) {
            if (mustAgree) {
                contractId = "{{$contracts->contract_id}}";
                var url = '{{ route("update.counter.offer", ":contractId") }}';
                url = url.replace(':contractId', contractId);
                axios({
                    method: 'GET',
                    url: url,
                })
                setTimeout(function () {
                    window.location.reload();
                }, 8000);
                // Custom logic for ‘new’ agreements
            }
        },
        // Called immediately upon user clicking ‘Decline’
        onDeclining: function (agreementData) {
            var url = '{{ route("decline.terms") }}';
            axios({
                method: 'get',
                url: url,
            })
        },
        // Called when a user declines and a response has been successfully stored (if Record Decline Responses is enabled)
        onDeclined: function (agreementData) {
            var url = '{{ route("decline.terms") }}';
            axios({
                method: 'get',
                url: url,
            })
        }
    }, '#ds-clickwrap')

</script>
