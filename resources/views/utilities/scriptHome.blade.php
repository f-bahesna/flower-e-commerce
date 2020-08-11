<script>
   $(function(){

// LOADER
    function loader(){
            $("body").fadeTo('slow',0.6);
            $("body").append(`<div class="d-flex justify-content-center loader">
                    <div class="spinner-grow" role="status" style="background-color: #8BBF43; width: 3rem; height: 3rem; margin-bottom:50px; position:relative;
                        margin: 0; position: absolute;  top: 50%;  left: 50%;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>`);
    }

    function removeLoader(){
            $("body").fadeTo('slow',1.0);
            $('.loader').remove();
    }
// END LOADER


//CATEGORIES
    $('.categories-list-a').on("click",function(){
     
        btn = $(this);
        val = btn.prev().val();
        //Toggle Class bg change
        $('.categories-list-a').css('background-color','white');
        $(this).css('background-color', '#8BBF43');

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('product.search.by.categorie') }}",
                data: {value : val},
                beforeSend: function() {    
                   loader();
                },
                success: function(res){
                    console.log(res);
                    $('#tableSearch').append("<h4>Kategori: "+res.categorie+"</h4>");
                    $("#row-product").html(res.view);
                    removeLoader();
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
    });
// END CATEGORIES

    $(".btn-collapse-right").hide();

    $('.btn-collapse-left').on('click', function(){
        $(".icon-left").fadeOut();
        $('#navbarResponsive').collapse('show');
        $(".btn-collapse-right").show();
    });

    $(".btn-collapse-right").on("click",function(){
        $('#navbarResponsive').collapse('hide');
        $(".icon-left").fadeIn();
        $(this).hide();
    });

        $("#tableSearch").on("keyup",function(){
            $("#carouselExampleIndicators").fadeOut();
            var value = $(this).val().toLowerCase();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('product.search') }}",
                data: {value : value},
                beforeSend: function() {    
                    isProcessing = true;
                },
                success: function(res){
                    $("#row-product").html(res.result);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        })

        $("#btn-register").on("click",function(){
            btn = $(this);
            btn.html(`<div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`)
        });

        $("#btn-login").on("click",function(){
            btn = $(this);
            btn.html(`<div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`)
        });

        $("#btn-logout").on("click",function(e){
            e.preventDefault();
            swal({
                title: "Yakin Logout ?",
                text: "Ketika logout, anda bisa login kembali!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willLogout) => {
                if (willLogout) {
                    window.location.href = "{{ route('user.logout') }}";
                } else {
                    // swal("Your imaginary file is safe!");
                }
            }); 
        });

        $(".dropdown-toggle").dropdown();

        //ADD TO CART
        $(".btn-masukan-keranjang").on('click',function(){
            btn = $(this);
            id = $("#product").val();
            cart = Number($(".countCart").text());
            id_user = $("#user").val();
            // console.log(cart + 1);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('product.add.cart') }}",
                data: {id : id},
                beforeSend: function() {    
                   btn.text('Proccessing...')
                   if(cart === null){
                       $(this).text(1);
                   }
                },
                success: function(res){
                    $(".countCart").text(cart + 1);
                    swal(res.message,"" , "success");
                    btn.text('+Masukan Keranjang');
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        })

       //User click CART behind username loggedin
        $(".shopping-cart").on("click",function(){
            btn = $(this);
            id_user = $("#user_id").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('show.cart.details') }}",
                data: { id_user : id_user },
                beforeSend: function() {    
                   btn.html(`<div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`)
                },
                success: function(res){
                $(".navbar-add").remove();
                $(".navbar-custom").remove();
                   $("#main-container").replaceWith(res);
                    btn.html(` <i class="fas fa-2x fa-shopping-cart"></i>
                            <span class="badge badge-danger ml-2 countCart"></span>`)
                },
                error: function(res) {
                    btn.html(` <i class="fas fa-2x fa-shopping-cart"></i>
                            <span class="badge badge-danger ml-2 countCart"></span>`)
                    swal("Keranjang Mu Kosong!", "Pilih product dan +MASUKAN KERANJANG", "warning");
                }
            });
        });

        //qty on change
        $('.qty-cart').on('change',function(e){
            thiz = $(this);
            $(this).parent().parent().next().html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
            type = "manual";
            value = $(this).val();
            id_product = $(this).parents().parents().parents().prev().val();
            calculateTotal(id_product , type , value ,thiz);
        });

        //CHANGE TOTAL FUNCTION
        function calculateTotal(id_product, type, value, thiz)
        {
            user_id = $("#user_id").val();
            b = $(".qty-cart").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('calculate.cart') }}",
                data: {user_id : user_id , id_product: id_product , type: type, value: value},
                beforeSend: function() {
                    //
                },
                success: function(res){
                    $(thiz).parent().parent().next().html(res.resultCalculate);
                    $(thiz).parent().parent().parent().parent().next().find('.subTotal').html(res.subTotal);
                    console.log(res);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        }

        $(".qty-cart-manual").on("change",function(){
            first_val = $(this).val();
            price_val = $(this).next().val();
            total_val = $(this).parent().next();
            
            func = Number(price_val) * Number(first_val);
        
            var bilangan = func;
                    
            var	reverse = bilangan.toString().split('').reverse().join(''),
                ribuan 	= reverse.match(/\d{1,3}/g);
                ribuan	= ribuan.join('.').split('').reverse().join('');
            // Cetak hasil	
            $(".manual-total").html(ribuan);
            // document.write(ribuan); 
        });

        //DELETE SELECTED PRODUCT
        $(".trash-cart-details").on("click",function(e){
            e.preventDefault();
            id_product = $(this).parent().parent().prev().val();
            user_id = $("#user_id").val();

            elem = $(this);

            swal({
                title: "Hapus Product ?",
                text: "Ketika terhapus, product akan terhapus dari keranjang anda!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "{{ route('delete.cart') }}",
                        data: {user_id : user_id , id_product: id_product},
                        beforeSend: function() {
                        
                        },
                        success: function(res){
                            $('.subTotal').html(res.subTotal);
                            $(elem).parent().parent().fadeOut();
                        },
                        error: function(res) {
                            $("#row-product").html(
                                '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                        }
                    });
                    swal("Product Terhapus!", {
                    icon: "success",
                    });
                } else {
                    // swal("Your imaginary file is safe!");
                }
            }); 
        });

//BUTTON PEMBAYARAN
        $(".btn-pembayaran").on({
            mouseenter: function () {
                $(this).css("background-color", "chartreuse");
            },
            mouseleave: function () {
                $(this).css("background-color", "yellow");
            }
        });

        $(".btn-pembayaran").on('click',function(){
            btn = $(this);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('cart.payment') }}",
                // data: {user_id : user_id , id_product: id_product , type: type, value: value},
                beforeSend: function() {
                    loader();
                    $(".btn-pembayaran-child").html(`LOADING ... `);
                },
                success: function(res){
                    $("#main-container").replaceWith(res);
                    $(".btn-pembayaran-child").html(`PEMBAYARAN`);
                    console.log(res);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        });
    //CHECKOUT
    $('.btn-beli-langsung').on("click",function(){
        btn = $(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('payment.checkout') }}",
                // data: {user_id : user_id , id_product: id_product , type: type, value: value},
                beforeSend: function() {
                    loader();
                    $(btn).html(`LOADING ... `);
                },
                success: function(res){
                    $("#main-container").replaceWith(res.view);
                    console.log(res);
                    $(this).html(`BELI LANGSUNG`);
                    removeLoader();
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
    });

    //END BUTTON PEMBAYARAN
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result);
                        $('#imagePreview').attr('src', e.target.result);
                    }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        //USER CHOOSE PROVINCE
        $(".province").on("change",function(){
            province_id = $(this).find(":selected").val();
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('get.province.id') }}",
                data: { id : province_id },
                beforeSend: function() {
                    $(".city").html(`<option value="">Loading ...</option>`);
                },
                success: function(res){
                    // console.log(res.endResultCity);
                    $(".city").html(res.city);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        });

        //fill postal code when user select selected city
        $(".city").on("change",function(){
            city_id = $(this).find(":selected").val();
            province_id = $(".province").find(":selected").val();
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('get.postal.code') }}",
                data: { province_id : province_id , city_id : city_id },
                beforeSend: function() {
                    $(".zip").attr('placeholder', 'Loading...');
                },
                success: function(res){
                    $(".zip").attr('placeholder', res.postal_code);
                    $(".zip").val(res.postal_code);
                    $(".courier").removeAttr('disabled');
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        });

        $(".courier").on("change",function(){
            $(this).empty();
            city_id = $(".city").find(":selected").val();
            province_id = $(".province").find(":selected").val();
            courier = $(this).val();
            weight = $(".weight-product").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('get.cost') }}",
                data: { province_id : province_id , city_id : city_id , courier : courier , weight : weight },
                beforeSend: function() {
                    $(".courier_service").html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                },
                success: function(res){
                    console.log(res.courier_service);
                    $(".courier_service").html(res.courier_service);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        });

        $("#exampleModal").scroll(function(){
            $('.card-cart').css('top',$(this).scrollTop());
        });
        
        //Tombol Bayar setelah pilih product,ongkir,kurir
        $('.manual-payment').on("click",function(){
            btn = $(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('store.manual.order') }}",
                data: { 
                    name : $('#firstName').val() , 
                    nomor_telephone: $('#notelp').val(),
                    email : $('#email').val(),
                    address : $('#address').val() , 
                    province : $(".province").find(":selected").text() ,
                    city : $(".city").find(":selected").text() ,
                    zip_code : $(".zip").find(":selected").val() ,
                    courier : $('input[name="radio"]:checked').val(),
                    courier_service : $('input[name="radio2"]:checked').val(),
                    courier_price : $('input[name="radio2"]:checked').attr('biaya'),
                    product_id :  $('#product').val(), 
                    harga :  $('.first_price').val(),
                    qty : $('.qty-cart-manual').val(),
                    notes: $('textarea[name="notes"]').val()
                },
                beforeSend: function() {
                    $(btn).html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                },
                success: function(res){
                    window.location = res.url;
                },
                error: function(res) {
                    console.log(res.responseJSON.message[2]);
                    $(btn).html('<h3 class="text-dark font-weight-bold">BAYAR</h3>');
                    swal("Tidak Dapat Diproses" , "Mohon Isi Data Anda Dengan BENAR", {
                        icon: "warning",
                    });
                }
            });
        });

        $(".input-courier-service").change(function(){
            a = $('.input-courier-service:checked').attr('biaya');
            alert(a);
        })

        $(".btn-check-pesanan").on("click",function(){
            btn = $(this);
            nomor_telephone = $(".nomor_telephone").val();
         
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('check.manual.order') }}",
                data: { nomor_telephone : nomor_telephone },
                beforeSend: function() {
                    $(btn).html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                    $(btn).prop('disabled', true);
                },
                success: function(res){
                    swal(res.message , {
                        icon: "success",
                    });
                    $(".col-cari-order-manual").html(res.data);
                    $(".col-cari-order-manual").prepend('<input type="hidden" id="nomor" value="'+ nomor_telephone +'">');
                },
                error: function(res) {
                    $(btn).html(`Cari`);
                    $(btn).prop('disabled', false);
                    swal("Data Order Tidak Ada" , "Periksa Nomor Anda Kembali" , {
                        icon: "warning",
                    });
                }
            });
        });

        //Batalkan Pesanan
        $(".btn-batalkan-pesanan").on("click",function(){
            btn = $(this);
            nomor_telephone = $("#nomor").val();
            alasan = $(".alasan-batal-pesanan").val();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('cancel.order') }}",
                data: { nomor_telephone : nomor_telephone , alasan : alasan },
                beforeSend: function() {
                    $(btn).html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                    $(btn).prop('disabled', true);
                },
                success: function(res){
                    swal(res.message , {
                        icon: "success",
                    }).then((value) => {
                        location.reload();
                    });
                   
                },
                error: function(res) {
                    swal(res.responseJSON.message , {
                        icon: "warning",
                    }).then((value) => {
                        location.reload();
                    });
                }
            });
        });

        //Check Automaticaly Number Telephone if Exist
        $("#nomor_telephone").on("change",function(){
            btn = $(this);
            nomor_telephone = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('check.number') }}",
                data: { nomor_telephone : nomor_telephone },
                beforeSend: function() {
                    $(btn).html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                },
                success: function(res){
                    $(btn).next().html(`<span class="text-success mt-3">Order Ditemukan & Nomor Telephone Valid</span>`);
                    $(".btn-payment-confirmation").prop("disabled", false);
                },
                error: function(res) {
                    $(btn).html(`Upload`);
                    $(btn).next().html(`<span class="text-danger mt-3"><h4 class="mt-2">ORDER TIDAK DITEMUKAN</h4></span> <hr/> <span class="text-danger mt-3">*Cek Nomor Telephonmu atau Hubungi Admin Untuk Dibantu</span>`);
                }
            });
        });

        //Upload Bukti Pembayaran
        $(".btn-payment-confirmation").on("click",function(){
            btn = $(this);
            nomor_telephone = $("#nomor_telephone").val();
            image = $("input#imageUpload");

            data = new FormData();
            data.append("image", image[0].files[0]);
            data.append("nomor", nomor_telephone);


            var reader = new FileReader();
            reader.readAsDataURL(image[0].files[0]);
            reader.onload = function (e) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('upload.payment.confirmation') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(btn).html(`<div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>`);
                    $(btn).prop('disabled', true);
                },
                success: function(res){
                    swal("Sukses!", res.message, "success", {
                        button: "Selesai!",
                    });
                    $(btn).html(`Upload`);
                    $("#nomor_telephone").val('');
                    $("input#imageUpload").val('');
                    $(btn).prop('disabled', false);
                },
                error: function(res) {
                    console.log(res);
                    $(btn).prop('disabled', false);
                    swal("Gagal!", res.responseJSON.message, "warning", {
                        button: "Selesai!",
                    });
                    $(btn).html(`Upload`)
                }
            });
        }
    });
});

</script>