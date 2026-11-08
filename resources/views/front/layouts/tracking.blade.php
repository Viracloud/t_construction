@if($global_setting->google_tag_id || $global_setting->google_ads_id)
<script>
(function () {
    var adsId = @json($global_setting->google_ads_id);
    var leadLabel = @json($global_setting->google_ads_label_lead);
    var phoneLabel = @json($global_setting->google_ads_label_phone);

    @if(session('lead_conversion'))
    // A contact / service enquiry form was just sent successfully
    gtag('event', 'generate_lead', { form_name: @json(session('lead_conversion')) });
    if (adsId && leadLabel) {
        gtag('event', 'conversion', { send_to: adsId + '/' + leadLabel });
    }
    @endif

    document.addEventListener('click', function (e) {
        var link = e.target.closest ? e.target.closest('a[href^="tel:"], a[href^="mailto:"]') : null;
        if (!link) return;
        if (link.getAttribute('href').indexOf('tel:') === 0) {
            gtag('event', 'phone_call_click', { link_url: link.getAttribute('href') });
            if (adsId && phoneLabel) {
                gtag('event', 'conversion', { send_to: adsId + '/' + phoneLabel });
            }
        } else {
            gtag('event', 'email_click', { link_url: link.getAttribute('href') });
        }
    });
})();
</script>
@endif
