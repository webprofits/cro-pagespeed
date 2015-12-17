<div class="main_section">
    <div class="grey_area"></div>
    <div class="content">
        <h1 class="center">Is your website ready for the mobile revolution?</h1>
        <p class="sub_h center">
            The world is moving to mobile fast. If your website isn't ready for the mobile revolution, then you'll be losing sales to the competition.
        </p>
        <div class="mobile_site_holder">
            <h3>Get a free mobile website analysis and instantly see how your website performs on mobile.</h3>
            <form action="results" method="POST" id="domain_form">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="site_form">
                    <div class="site_input">
                        <div class="input_text nb_right">
                            <input type="text" placeholder="Step 1. Enter your website address" name="url" id="url" value="{{old('url')}}">
@if($errors)
                            <label id="url-error" class="error" for="url">{{ $errors->first('url') }}</label>
@endif
                        </div>
                        <button type="button" class="nxt">NEXT</button>
                    </div>
                </div>
            </form>

            <form accept-charset="UTF-8" action="https://webprofits.infusionsoft.com/app/form/process/88e463df4cb636bf3de7b5daddc6d0df" id="email_form" class="infusion-form" method="POST">
                <input name="inf_form_xid" type="hidden" value="88e463df4cb636bf3de7b5daddc6d0df" />
                <input name="inf_form_name" type="hidden" value="Mobile Responsive Offer" />
                <input name="infusionsoft_version" type="hidden" value="1.39.0.34" />

                <input type="hidden" name="inf_field_Website" value="">
                <div class="email_form">
                    <div class="_for_the_validator_">
                        <div class="firstname_input">
                            <div class="input_text">
                                <input type="text" placeholder="Step 2. Enter your first name" name="inf_field_FirstName" id="first_name" value="{{old('first_name')}}">
                            </div>
                        </div>
                    </div>

                    <div class="email_input">
                        <div class="input_text nb_right">
                            <input type="text" placeholder="Step 3. Enter your email address" name="inf_field_Email" id="email" value="{{old('email')}}">
                        </div>
                        <button class="nxt">NEXT</button>
                    </div>
                </div>
            </form>
        </div>
        <p class="testimonial center">
            “Gorgeous visual style, cutting edge technical <br />
            prowess and old-school salesmanship are at the core of <br />
            this great team.”
        </p>
        <div class="author_wr clearfix">
            <img class="left" src="images/author_img.jpg" />
            <p class="author left">Matt Dale <br /><span class="position">Digital Creative Manager, Zip</span></p>
        </div>
    </div>
</div> <!--//main_section-->

<div class="domain_section">
    <!-- < domain section ... > -->
</div>
