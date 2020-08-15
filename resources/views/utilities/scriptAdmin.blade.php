<script>
    $(function(){
        //PRODUCT
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

        $('.btn-delete-product').on("click",function(){
            id = $(this).parent().prev().val();
            btn = $(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('delete.products') }}",
                data: {id : id},
                beforeSend: function() {    
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

        $('#zoom-image').ezPlus();

        $('.change-publish').on("click",function(){
            btn = $(this);
            status = $(this).attr('status');
            product_id = $(this).parent().parent().parent().find('.product-id').val();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('change.publish') }}",
                data: {status : status , product_id: product_id},
                beforeSend: function() {  
                //
                },
                success: function(res){
                    swal("Sukses!");
                    if(res.btn == 'Drafted'){
                        $(btn).parent().prev().removeClass('btn-success');
                        $(btn).parent().prev().addClass('btn-warning');
                    }else{
                        $(btn).parent().prev().removeClass('btn-warning');
                        $(btn).parent().prev().addClass('btn-success');
                    }

                    $('.btn-change').html(res.btn);
                },
                error: function(res) {
                    swal("Sukses!", res.message, {
                        button: "Selesai!",
                    }).then((value) => {
                        location.reload();
                    });
                }
            });
        })

        //END PRODUCT



        $("#table-product tbody.manual tr").on("click",function(){
            //order details
            $('.btn-tolak').show();
            status = $(this).find('.apn-status').val();
            $('.btn-packing').attr('disabled',false);
            switch(status){
                case 'waiting':
                $('.btn-packing').text('Packing');
                break;
                case 'packing':
                $('.btn-packing').text('Shipping');
                break;
                case 'shipping':
                $('.btn-packing').text('Done');
                break;
                case 'cancel_process':
                $('.btn-packing').attr('disabled',true);
                break;
                case 'verification':
                $('.btn-packing').attr('disabled',true);
                break;
                case 'canceled':
                $('.btn-packing').attr('disabled',true);
                break;
            }
            if(status != 'waiting'){
                $('.btn-tolak').hide();
            }
            order_code = $(this).find('.apn-order-code').val();
            $('.for-order-code-tolak').val(order_code);
            address = $(this).find('.apn-address').val();
            province = $(this).find('.apn-province').val();
            qty = $(this).find('.apn-qty').text();
            city = $(this).find('.apn-city').text();
            
            //kurir
            courier = $(this).find('.apn-courier').val();
            courier_service = $(this).find('.apn-courier-service').val();
            courier_price = $(this).find('.apn-courier-price').val();
            total_price = $(this).find('.apn-total-price').val();
            notes = $(this).find('.apn-notes').val();

            //product
            nama_product = $(this).find('.apn-nama-product').val();
            jenis = $(this).find('.apn-jenis-product').val();
            harga_product = $(this).find('.apn-harga-product').val();
            berat = $(this).find('.apn-berat-product').val();

            //payment
            payment = $(this).find('.apn-payment-confirmation-image').attr('src');
            //APPEND
            $('.modal-image-payment-confirmation').attr('src',payment)

            $('.modal-notes').text(notes);
            //PRODUCT DETAILS
            $('.for-order-status').val(status);
            $('.modal-order-code').text(order_code);
            $('.modal-nama-product').text('Nama Product : '+nama_product);
            $('.modal-jenis-product').text('Jenis : '+jenis);
            $('.modal-dipesan').text('Dipesan : '+qty);
            $('.modal-harga-product').text('Harga. '+(harga_product/1000).toFixed(3));
            $('.modal-berat-product').text('Berat : '+berat);

            //ADDRESS & COURIER
            $('.modal-pengiriman').text('Alamat Pengiriman : '+address);
            $('.modal-provinsi').text('Provinsi : '+province);
            $('.modal-city').text('Kota : '+city);
            $('.modal-kurir').text('Kurir : '+courier);
            $('.modal-kurir-service').text('Servis Kurir : '+courier_service);
            $('.modal-ongkir').text('Biaya Ongkir '+(courier_price/1000).toFixed(3));

            $('.modal-total-price').text('RP. '+(total_price/1000).toFixed(3));

            $('#exampleModalCenter').modal('show');
        });
        //TOLAK SECTION
        $(".row-tolak").hide();
        $(".btn-tolak").on("click",function(){
            $(".row-tolak").fadeIn();
        });

        $(".btn-cancel-tolak").on("click",function(){
            $(".row-tolak").fadeOut();
        })

        $(".btn-confirm-tolak").on("click",function(){
            btn = $(this);
            order_code =  $(this).prev().val();
            textarea = $(this).prev().prev().prev().val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('tolak.order') }}",
                data: {order_code : order_code , notes: textarea},
                beforeSend: function() {  
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
                error: function(res) {
                    swal("Sukses!", res.message, "danger", {
                        button: "Selesai!",
                    }).then((value) => {
                        location.reload();
                    });
                }
            });
        })

        $(".btn-packing").on("click",function(){
            btn = $(this);
            order_code = $(this).parent().prev().find('.modal-order-code').text();
            status = $(this).next().val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('packing.order') }}",
                data: {order_code: order_code , status:status},
                beforeSend: function() {
                    btn.html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`); 
                },
                success: function(res){
                    swal("Sukses!", res.message, "success", {
                        button: "Selesai!",
                    }).then((value) => {
                        location.reload();
                    });
                },
                error: function(res){
                    swal("Gagal!", res.message, "danger", {
                        button: "Selesai!",
                    }).then((value) => {
                        location.reload();
                    });
                }
            })
        });

})
</script>