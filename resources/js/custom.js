$(document).on('click','.call-docusign',function(){
    $(this).prop('disabled', true);
    $(".set-terms-form").submit();
});