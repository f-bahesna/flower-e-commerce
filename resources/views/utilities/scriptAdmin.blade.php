<script>
    $(function(){
      function readURL(input ,dom) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result);
                        $(dom).attr('src', e.target.result);
                    }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".gambar-utama").change(function() {
            dom = $('.img-gambar-utama');
            readURL(this , dom);
        });
        $(".gambar-lainnya").change(function() {
            dom = $(this).prev();
            readURL(this , dom);
        });


        $('input[name="gambar-lainnya[]"]').on("change",function(e){
          e.preventDefault();

            $(this).parent().append('<a class="btn btn-success btn-md mt-2 btn-save-add">Simpan</a>');
            $(".btn-save-edit").prop('disabled',true);
            $(".alert-gambar-lainnya").append('<p class="text-danger add-text-alert">*Simpan gambar lainnya terlebih dahulu</p>');

        });

        $(".gambar_lainnya").on("click",".btn-save-add", function(e){
            e.preventDefault();
            btn = $(this);
            number_pic =  $(this).prev().val();
            image = $(this).prev().prev().prev();
            product_id = $(this).prev().prev().val();
            
            data = new FormData();
            data.append("image", image[0].files[0]);
            data.append("number_pic", number_pic);
            data.append("product_id", product_id);

            var reader = new FileReader();
            reader.readAsDataURL(image[0].files[0]);
            reader.onload = function (e) {
                    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('save.another.image') }}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                       btn.html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                    },
                    success: function(res){
                        swal("Success",res.message,{
                            button: "Selesai",
                            icon : "success"
                        });
                        btn.html(`<i class="fas fa-2x fa-check"></i>`);
                        $(".btn-save-edit").prop('disabled',false);
                        $(".add-text-alert").hide();
                    },
                    error: function(res) {
                        $("#row-product").html(
                            '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                    }
                });
            }
        });
})
</script>