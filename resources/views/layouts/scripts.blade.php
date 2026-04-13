@push('scripts')
<script>
      $('.add-to-cart-btn').click(function(e){
        e.preventDefault();

        let ptok = $(this).data('ptok');
        let quantity = 1; // default quantity, ya input field se le lo

        $.ajax({
            url: "{{ route('cart.add') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ptok: ptok,
                quantity: quantity
            },
            success: function(res){
                if(res.success){
                    // Example: toast / alert notification
                    // alert(res.message);

                    // Optional: update cart count in navbar
                    let cartCount = parseInt($('#cart-count').text()) || 0;
                    $('#cart-count').text(cartCount + quantity);

                    $('#cart-count').show();

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: res.message,
                        showCancelButton: true,
                        confirmButtonText: 'View Cart',
                        cancelButtonText: 'Continue Shopping',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#aaa'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{route('cart')}}";
                        }
                    });
                }
            },
            error: function(err){
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong, please try again!'
                });
            }
        });
    });


    window.addEventListener("pageshow", function(event) {

    if (event.persisted) {
        location.reload();
    }

});
</script>
@endpush
