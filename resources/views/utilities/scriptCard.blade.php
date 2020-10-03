<script>
    $(function(){
        $('.btn-edit-profile').on("click",function(){
            btn = $(this);

            btn.removeClass('btn-edit-profile');
            btn.addClass('btn-save');
            btn.prev().find('.form-control').removeAttr('disabled');
            btn.html('Simpan');

            btn.prev().append('<button class="btn float-right mt-4 btn-sm btn-danger btn-cancel">Cancel</button>')

        });

        $('.btn-cancel').on("click",function(){
            btn = $(this);
            btn.hide();
            btn.prev().find('.form-control').addAttr('disabled');
        });



        $('.btn-save').on("click",function(){
            btn = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name"csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('delete.products') }}",
                data: {id : id},
                beforeSend: function(){
                    btn.html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`); 
                },
                success: function(res){
                    swal("Sukses!", res.message, "danger", {
                        button: "Selesai!",
                    }).then((value) => {
                        location.reload();
                    });
                },
                error: function(res){
                    swal("Sukses!", res.message, "danger", {
                        button: "Selesai!",
                    }).then((value) => {
                        location.reload();
                    });
                }
            });
        });
    });
</script>