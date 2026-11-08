<script src="{{ asset('dist-front/js/jquery.min.js') }}"></script>
<script src="{{ asset('dist-front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist-front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('dist-front/js/glightbox.min.js') }}"></script>
<script src="{{ asset('dist-admin/js/iziToast.min.js') }}"></script>

<script type="text/javascript">
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });
</script>
<script src="{{ asset('dist-front/js/custom.js') }}"></script>
@if($global_setting->layout_direction == 'ltr')
<script src="{{ asset('dist-front/js/ltr.js') }}"></script>
@endif
@if($global_setting->layout_direction == 'rtl')
<script src="{{ asset('dist-front/js/rtl.js') }}"></script>
@endif

<script>
    // Thumbnail gallery - click to swap main image
    document.querySelectorAll('.product-thumb').forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            var newSrc = this.getAttribute('data-image');
            var mainImg = document.getElementById('mainProductImage');
            mainImg.style.opacity = '0';
            setTimeout(function() {
                mainImg.src = newSrc;
                mainImg.style.opacity = '1';
            }, 200);

            document.querySelectorAll('.product-thumb').forEach(function(t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Quantity increment / decrement
    document.getElementById('qtyMinus').addEventListener('click', function() {
        var input = document.getElementById('qtyInput');
        var val = parseInt(input.value);
        if (val > 1) input.value = val - 1;
    });
    document.getElementById('qtyPlus').addEventListener('click', function() {
        var input = document.getElementById('qtyInput');
        var val = parseInt(input.value);
        if (val < 99) input.value = val + 1;
    });

    // Review star rating
    document.querySelectorAll('.review-star').forEach(function(star) {
        star.addEventListener('click', function() {
            var rating = parseInt(this.getAttribute('data-rating'));
            document.querySelectorAll('.review-star').forEach(function(s, i) {
                if (i < rating) {
                    s.classList.remove('fa-regular');
                    s.classList.add('fa-solid');
                    s.style.color = '#ffc107';
                } else {
                    s.classList.remove('fa-solid');
                    s.classList.add('fa-regular');
                    s.style.color = '';
                }
            });
        });

        star.addEventListener('mouseenter', function() {
            var rating = parseInt(this.getAttribute('data-rating'));
            document.querySelectorAll('.review-star').forEach(function(s, i) {
                s.style.color = (i < rating) ? '#ffc107' : '';
            });
        });
    });

    document.querySelector('.review-stars').addEventListener('mouseleave', function() {
        document.querySelectorAll('.review-star').forEach(function(s) {
            if (s.classList.contains('fa-solid')) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '';
            }
        });
    });
</script>


@if($errors->any())
    <script>
        iziToast.error({
            message: '{{ $errors->first() }}',
            position: 'topRight'
        });
    </script>
@endif

@if(session('success'))
    <script>
        iziToast.success({
            message: '{{ session('success') }}',
            position: 'topRight'
        });
    </script>
@endif

@if(session('error'))
    <script>
        iziToast.error({
            message: '{{ session('error') }}',
            position: 'topRight'
        });
    </script>
@endif