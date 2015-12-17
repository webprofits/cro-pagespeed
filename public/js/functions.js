$ = jQuery;
var loadedValidationCode = false;

function moveProgressBar() {
    $('.progress-wrap').each(function(index, element) {
        var getPercent = ($(this).data('progress-percent') / 100);
        var getProgressWrapWidth = $(this).width();
        var progressTotal = getPercent * getProgressWrapWidth;
        var animationLength = 200;

        // on page load, animate percentage bar to data percentage length
        // .stop() used to prevent animation queueing
        $( this ).find('.progress-bar').stop().animate({
            left: progressTotal
        }, animationLength);
    });
}

$(document).ready(function(){

    moveProgressBar();

	$('input, textarea').placeholder();

	$("input").focus(function(){
        if (!loadedValidationCode) {
            loadedValidationCode = true;
            loadCode();
        }
		$(this).parent().addClass("focus");
	}).blur(function(){
		$(this).parent().removeClass("focus");
	});
	
	$("textarea").focus(function(){
		$(this).parent().addClass("focus");
	}).blur(function(){
		$(this).parent().removeClass("focus");
	});

    /**
     * Add some funky domain validation!
     */
    jQuery.validator.addMethod("domain", function(value, element) {
        var regex = /^(https?:\/\/)?((?!-))(xn--)?[a-z0-9][a-z0-9-_]{0,61}[a-z0-9]{0,1}\.(xn--)?([a-z0-9\-]{1,61}|[a-z0-9-]{1,30}\.[a-z]{2,})(\.|[^\/]*$)?/;
        return regex.test(value.trim());
    }, "Please specify a correct domain for your free mobile website analysis");

    /**
     * And some new form functionality \o/
     */
    $('.get_in_touch').click(function(event){

        $('.get_in_touch').css('display','none');

        $('#full-form').slideDown(1000, function() {
            $('#full-form').css('display','block');
            $(this).css('display','block');
        });

    });
});

function loadCode() {
    function stepOneButton() {
        if ($("#domain_form").valid()) {
            $("#email_form input[name='inf_field_Website']").val($("#domain_form input[name='url']").val());
            $("#domain_form").slideUp();
            $(".email_form").slideDown();
        }
    }

    if ($("#domain_form").length == 1) {
        // Validate form
        $("#email_form").validate({
            errorPlacement: function(error, element) {
                error.appendTo( element.parent().parent().first() );
            },
            rules: {
                inf_field_FirstName: {
                    required: true,
                    minlength: 2
                },
                inf_field_Email: "required email"
            }
        });

        $("#domain_form").validate({
            rules: {
                url: "required domain"
            }
        });

        $("#domain_form").submit(function(e) {
            // Stop the form from submitting, and move the URL to the email form...
            stepOneButton();

            e.preventDefault();
            return false;
        })

        $("#domain_form .nxt").click(function(e) {
            stepOneButton();
        })
    }

    if ($(".contact_form").length > 1) {
        // Validate *contact* form.
        $(".contact_form").each(function() {
            $("#" + $(this).attr('id')).validate({
                errorPlacement: function(error, element) {
                    error.prependTo( element.parent().parent().first() );
                },
                rules: {
                    website: "required",
                    firstname: {
                        required: true,
                        minlength: 2
                    },
                    lastname: "required",
                    company: "required",
                    phone: "required",
                    email: "required email",
                    job_title: "required",
                    message: "optional"
                },
                messages: {
                    firstname: {
                        required: "We need your first name to contact you",
                        minlength: $.validator.format("At least {0} characters required!")
                    },
                    email: {
                        required: "We need your email address to contact you"
                    }
                }
            })
        })
    }
}

$(window).resize(function() {
    moveProgressBar();
});

/*
$("#gogogo").click(function() {
    var form = $("#domain_form");
    if (form.valid()) {
        /** perform an ajax request. on success, move the other content up, and fill with new content. ** /
    }
});
*/

$('a.findoutmore').click(function(e) {
    // Find out more button...
})

function reloadJcaptcha() {
    var now = new Date();
    if (document.images) {
        document.images.captcha.src = 'https://webprofits.infusionsoft.com/Jcaptcha/img.jsp?reload=' + now
    }
}

