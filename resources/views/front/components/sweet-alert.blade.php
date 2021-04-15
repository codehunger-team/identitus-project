<script>
    swal({title: "{{ session()->get('message')}}", type: "{{ session()->get('message_type') }}",timer:2000});
</script>