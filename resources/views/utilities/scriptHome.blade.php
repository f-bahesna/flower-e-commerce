<script>
   $(function(){
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

        $(".btn-masukan-keranjang").on('click',function(){
            btn = $(this);
            id = $("#product").val();
            cart = Number($(".countCart").text()) + 1;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                // url: "{{ route('product.add.cart') }}",
                url: "/add-cart",
                data: {id : id},
                beforeSend: function() {    
                   btn.text('Proccessing...')
                    // if(cart < 2){
                    //     $(".countCart").text(cart);
                    // }
                    $(".countCart").animate({
                        fontSize: '20px'
                    });             
                },
                success: function(res){
                    console.log(res);
                    alert(res.responseJSON);
                    $(".countCart").text(cart);
                        btn.text('+Masukan Keranjang');
                },
                error: function(res) {
                    console.log(res);
                    $("#row-product").html(
                        '<div><h5 class="text-danger"> '+ res.responseJSON.result +'</h5></div>');
                }
            });
        })
   });


    /*
                        Add to cart fly effect with jQuery. - May 05, 2013
                        (c) 2013 @ElmahdiMahmoud - fikra-masri.by
                        license: https://www.opensource.org/licenses/mit-license.php
                    */   
                    // var cart = $('.shopping-cart');
                    // var imgtodrag = $('.img-product-animation').find("img").eq(0);
                    // if (imgtodrag) {
                    //     var imgclone = imgtodrag.clone()
                    //         .offset({
                    //         top: imgtodrag.offset().top,
                    //         left: imgtodrag.offset().left
                    //     })
                    //         .css({
                    //         'opacity': '0.8',
                    //             'position': 'absolute',
                    //             'height': '50px',
                    //             'width': '20px',
                    //             'z-index': '50'
                    //     })
                    //         .appendTo($('body'))
                    //         .animate({
                    //         'top': cart.offset().top + 5,
                    //             'left': cart.offset().left + 5,
                    //             'width': 20,
                    //             'height': 20
                    //     }, 1000, 'easeInOutExpo');
                    //     imgclone.animate({
                    //         'width': 0,
                    //         'height': 0
                    //     }, function () {
                    //         $(this).detach()
                    //     });
                    // }
</script>