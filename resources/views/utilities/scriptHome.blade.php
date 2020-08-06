<script>
   $(function(){

// LOADER
    function loader(){
            $("body").fadeTo('slow',0.6);
            $("body").append(`<div class="d-flex justify-content-center">
                    <div class="spinner-grow" role="status" style="width: 3rem; height: 3rem; margin-bottom:50px; position:relative;
                        margin: 0; position: absolute;  top: 50%;  left: 50%;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>`);
    }

    function loaderRemove(){
            $("body").fadeTo('slow',1.0);
            $('.loader').remove();
    }
// END LOADER

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

   });

</script>