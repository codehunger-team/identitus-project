<!---modal popup ------------>
<div class="modal fade" id="tos-popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 mx-auto">
                        <p>
                            <div name="termly-embed" data-id="003bc7d0-817f-4528-9353-8cbbf031dee6" data-type="iframe"></div>
                            <script type="text/javascript">(function(d, s, id) {
                                var js, tjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "https://app.termly.io/embed-policy.min.js";
                                tjs.parentNode.insertBefore(js, tjs);
                                }(document, 'script', 'termly-jssdk'));
                            </script>
                        </p>
                    </div>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="member-reject-button" onclick="rejectAgreement()" data-bs-dismiss="modal">No, I don't</button>
                <button type="button" class="btn btn-primary" id="member-accept-button" onclick="closeTheModal()">Yes, I Agree</button>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------->
