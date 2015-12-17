<form accept-charset="UTF-8" action="https://webprofits.infusionsoft.com/app/form/process/36c001f7a61f6e113a7659ea985f4ed5" method="POST" class="contact_form" id="t{{ rand() }}z{{ rand() }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input name="inf_form_xid" type="hidden" value="36c001f7a61f6e113a7659ea985f4ed5" />
    <input name="inf_form_name" type="hidden" value="Free Conversion Review" />
    <input name="infusionsoft_version" type="hidden" value="1.31.0.33" />

    <div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_Website" id="website" placeholder="Your Website" value="{{$results['url']}}"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_FirstName" id="firstname" placeholder="First Name" value="{{$results['first_name']}}"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_LastName" id="lastname" placeholder="Last Name"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_Company" id="company" placeholder="Company"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_Phone1" id="phone" placeholder="Phone"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_Email" id="email" placeholder="Email"  value="{{$results['email']}}"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text">
                <input type="text" name="inf_field_JobTitle" id="job_title" placeholder="Job Title"/>
            </div>
        </div>
        <div class="_for_the_validator_">
            <div class="input_text tx_area">
                <textarea name="inf_custom_Message" id="message" placeholder="Message"></textarea>
            </div>
        </div>
             <div class="ver">
                 <img border="0px" title="If you can't read the image, click it to get another one." src="https://webprofits.infusionsoft.com/Jcaptcha/img.jsp" onClick="reloadJcaptcha();" name="captcha" alt="captcha"> 
             </div>
             <div class="input_text">
                 <input type="text" placeholder="Verification" />
             </div>
        <button class="rev">Review My Website</button>
        <p class="form_info">Please appreciate that these free reports will not be released to our competitors.</p>
    </div>
</form>
