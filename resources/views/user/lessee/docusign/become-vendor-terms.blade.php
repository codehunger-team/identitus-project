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
                var url = '{{ route("user.update") }}';
                axios({
                    method: 'POST',
                    url: url,
                    data: {
                        is_vendor: 'yes',
                    }
                })
                setTimeout(function () {
                    window.location.reload();
                }, 6000);
            }
        },
    }, '#ds-clickwrap')
    
</script>
