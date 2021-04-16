@if(session()->has('message'))
<script>
    swal({title: "{{ session()->get('message')}}", icon: "success",timer:3000});
</script>
@endif