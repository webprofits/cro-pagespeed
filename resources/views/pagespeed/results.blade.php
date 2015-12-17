@extends('pagespeed.layout')

@section('title')
@if ($version !== 2)
<title>Mobile Responsive Results - Web Profits</title>
@else
<title>Mobile Responsive Results - Web Profits</title>
@endif
@stop

@section('body')
    <div class="container">
        <div class="header clearfix">
            <div class="content">
                <div class="logo">
                    <img src="{{asset('images/logo.png')}}" />
                </div>
                <div class="call_us_wr">
                    <p><span class="hide_mob">Call Us </span><a class="call_us" href="tel:1800932776">1800 932 776</a></p>
                </div>
            </div>
        </div> <!--//Header-->

        <div class="__content">
        @if ($version == 2)
            @include('pagespeed.domain_section_v2')
        @else
            @include('pagespeed.domain_section')
        @endif
        </div>

        <div class="footer">
            <div class="content clearfix">
                <p>© Web Profits. All right reserved   |   <a href="https://www.webprofits.com.au/privacy.html" target="_blank">Privacy Policy</a></p>
            </div>
        </div> <!--//Footer-->

    </div> <!--//Container-->
<!-- Facebook Conversion Code for Mobile Responsive Report -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6028144831813', {'value':'0.00','currency':'AUD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6028144831813&amp;cd[value]=0.00&amp;cd[currency]=AUD&amp;noscript=1" /></noscript>
<!--end-->
@stop
