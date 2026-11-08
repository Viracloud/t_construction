<footer class="tmp-footer-area footer-bg pt--100 position-relative">
    <div class="container">
        <div class="row g-4 pb-5 border-bottom border-secondary border-opacity-25">
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$global_setting->logo_2) }}" class="mb-4 footer-logo-size" alt="{{ $global_setting->site_name }}">
                    <p class="description des-col1 mb-3">Luxury Wall Finishes Made Affordable.</p>
                    <div class="social-icons d-flex gap-2">
                        @if($global_setting->footer_facebook != '')
                            <a href="{{ $global_setting->footer_facebook }}" class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($global_setting->footer_twitter != '')
                            <a href="{{ $global_setting->footer_twitter }}" class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if($global_setting->footer_linkedin != '')
                            <a href="{{ $global_setting->footer_linkedin }}" class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        @endif
                        @if($global_setting->footer_instagram != '')
                            <a href="{{ $global_setting->footer_instagram }}" class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="title fw-bold mb-4">Important Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('about') }}" class="text-decoration-none description">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="text-decoration-none description">Our Services</a></li>
                    <li><a href="{{ route('projects') }}" class="text-decoration-none description">Our Projects</a></li>
                    <li><a href="{{ route('gallery') }}" class="text-decoration-none description">Photo Gallery</a></li>
                    <li><a href="{{ route('members') }}" class="text-decoration-none description">Team Members</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="title fw-bold mb-4">Need Help?</h5>
                <div class="mb-3">
                    <p class="description">Call US Directly?</p>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $global_setting->footer_phone) }}" class="title fw-bold text-decoration-none">{{ $global_setting->footer_phone }}</a>
                </div>
                <div>
                    <p class="description">For Support?</p>
                    <a href="mailto:{{ $global_setting->footer_email }}" class="title fw-bold text-decoration-none">{{ $global_setting->footer_email }}</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12">
                <h5 class="title fw-bold mb-4">Subscribe Now</h5>
                <p class="description des-sub small">Subscribe today and explore the newest trends in plastering, rendering, and decorative finishes.</p>
                <form action="{{ route('subscriber_send_email') }}" class="position-relative form_subscribe_ajax" method="post">
                    @csrf
                    <input name="email" type="text" class="form-control rounded-pill ps-4 pe-5 py-3" placeholder="Enter your email">
                    <button type="submit" class="btn mail-btns rounded-circle position-absolute top-50 end-0 translate-middle-y me-1 p-2 size-40">
                        <i class="fa-regular fa-envelope text-white-rgb"></i>
                    </button>
                </form>
                <div id="loader"></div>
            </div>
        </div>

        <div class="py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 description">
                        {{ $global_setting->footer_copyright }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="{{ route('privacy') }}" class="description text-decoration-none me-3">Privacy policy</a>
                    <a href="{{ route('terms') }}" class="description text-decoration-none">Terms and Condition</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="float-text show-on-scroll show">
    <span><a href="#">Scroll to top</a></span>
    <div class="scroll-progress-container">
        <div class="scroll-progress-bar"></div>
    </div>
</div>
@push('scripts')
<script>
$(".form_subscribe_ajax").on('submit', function(e){
    e.preventDefault();
    $('#loader').show();
    var form = this;
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
            //$(form).find('span.error-text').text('');
        },
        success:function(data)
        {
            $('#loader').hide();
            if(data.code == 0)
            {
                if (typeof data.error_message === 'string') {
                    // Apply iziToast
                    iziToast.error({
                        title: 'Error',
                        message: data.error_message,
                        position: 'topRight'
                    });
                } else {
                    $.each(data.error_message, function(prefix, val) {
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                        // Apply iziToast
                        iziToast.error({
                            title: 'Error',
                            message: val[0],
                            position: 'topRight'
                        });
                    });
                }
            }
            else if(data.code == 1)
            {
                $(form)[0].reset();
                //alert(data.success_message);
                // Apply iziToast
                iziToast.success({
                    title: 'Success',
                    message: data.success_message,
                    position: 'topRight'
                });
            }
            
        },
        error:function()
        {
            $('#loader').hide();
            //alert('Request failed. Please try again.');
            // Apply iziToast
            iziToast.error({
                title: 'Error',
                message: 'Request failed. Please try again.',
                position: 'topRight'
            });
        }
    });
});
</script>
@endpush