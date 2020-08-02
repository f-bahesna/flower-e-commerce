<script>
   $(function(){
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

        $("#btn-logout").on("click",function(){
            $("#logout-modal").modal('show');
        });

        $(".dropdown-toggle").dropdown();

//ADD TO CART
        $(".btn-masukan-keranjang").on('click',function(){
            btn = $(this);
            id = $("#product").val();
            cart = Number($(".countCart").text());
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
                    alert(res.message);
                    $(".countCart").text(cart + 1);
                    btn.text('+Masukan Keranjang');
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        })

//AUTO update when cart is checked!!
        $(".shopping-cart").on("click",function(){
            $("#modalAbandonedCart").modal("show");
            id = $("#product").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('show.cart') }}",
                data: {id : id},
                beforeSend: function() {    
                 $(".target-modal-body").html(`<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    </div>`);
                },
                success: function(res){
                    console.log(res.data);
                 $(".target-modal-body").html(res.data);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        });

        $('.btn-ke-keranjang').on("click",function(){
            $(this).html(`<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
            </div>`);
        })
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

        //minus product
        // $(".minus").click(function(){
        //     $(this).parents().parents().next().html(`<div class="d-flex justify-content-center">
        //                                                 <div class="spinner-border" role="status">
        //                                                     <span class="sr-only">Loading...</span>
        //                                                 </div>
        //                                             </div>`);
        //     type = "minus";
        //     value = 0;
        //     id_product = $(this).parents().parents().parents().prev().val();
        //     calculateTotal(id_product);
        // })
        //plus product
        // $(".plus").click(function(){
        //     $(this).parents().parents().next().html(`<div class="d-flex justify-content-center">
        //                                                 <div class="spinner-border" role="status">
        //                                                     <span class="sr-only">Loading...</span>
        //                                                 </div>
        //                                             </div>`);
        //     type = "plus";
        //     value = 0;
        //     id_product = $(this).parents().parents().parents().prev().val();
        //     calculateTotal(id_product);
        // })

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
                    
                },
                success: function(res){
                    $(thiz).parent().parent().next().html(res.resultCalculate);
                    console.log(res);
                },
                error: function(res) {
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        }

   });

</script>