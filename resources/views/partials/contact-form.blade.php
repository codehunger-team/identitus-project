<form id="biscolab-recaptcha-invisible-form" class="py-4" method="post">
    @csrf
    <div class="form-floating mb-3">
        <input type="text" class="form-control name" id="name" name="name"
            aria-describedby="name" placeholder="Full Name" required>
        <label for="name">Full Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control email" id="email" name="email" required>
        <label for="email">Email Address</label>
    </div>
    <div class="form-floating">
        <textarea class="form-control message"  name="message"
            placeholder="Leave a comment here" id="contactMessage" style="height: 100px" required></textarea>
        <label for="contactMessage">Comments</label>
    </div>
    <button class="g-recaptcha btn btn-warning my-2 float-end" data-sitekey="{{env('RECAPTCHA_SITE_KEY')}}"
        data-callback='onSubmit' data-action='submit'>Submit</button>
</form>

<script>
    function onSubmit(token) {
        var bodyFormData = {
            'name' : $('#name').val(),
            'email' : $('#email').val(),
            'message' : $('#contactMessage').val(),
            'recaptchaToken': token,
        };
        axios({
                method: "post",
                url: "{{route('send.enquiry')}}",
                data: bodyFormData,
            })
            .then(function (response) {
                if(response.data.success == false) {
                    $.each(response.data.errors, function(key, value) {
                        $('.'+key).addClass("is-invalid");
                    });
                } else if(response.data.success == true) {
                    location.reload();
                }
            })
            .catch(function (response) {
                console.log(response);
            });
    }

</script>
