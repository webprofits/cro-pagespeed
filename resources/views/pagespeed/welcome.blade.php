@extends('pagespeed.layout')

@section('title')
<title>Mobile Website Checker - Web Profits</title>
@stop

@section('body')
    <div class="container">
        <div class="header clearfix">
            <div class="content">
                <div class="logo">
                    <img src="images/logo.png" />
                </div>
                <div class="call_us_wr">
                    <p><span class="hide_mob">Call Us </span><a class="call_us" href="tel:1800932776">1800 932 776</a></p>
                </div>
            </div>
        </div> <!--//Header-->

        <div class="__content">
            @include('pagespeed.main_section')
        </div>

        <div class="footer">
            <div class="content clearfix">
                <p>© Web Profits. All right reserved   |   <a href="https://www.webprofits.com.au/privacy.html" target="_blank">Privacy Policy</a></p>
            </div>
        </div> <!--//Footer-->

    </div> <!--//Container-->
@stop
