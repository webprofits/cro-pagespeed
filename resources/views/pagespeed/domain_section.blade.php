<?php
function what_type($rule_impact) {
    if ($rule_impact > 15)
        return 'should';
    return 'consider';
}

function impact_message($impact) {
    if ($impact == 'consider')
        return '<p class="sugest"><span class="consider"></span>Consider Fixing:</p>';
    return '<p class="sugest"><span class="should"></span>Should Fix:</p>';
}
?>

@section('title')
<title>Results - Web Profits</title>
@stop

<div class="main_section2">
    <div class="grey_section">
        <div class="content">
            <div class="info_section">
                <h1>Mobile Website Analysis</h1>
                <p class="site_name" title="{{ $results['url'] }}">{{ $results['url'] }}</p>
                <p class="score"><span>{{ $results['total'] }} / 200</span> - Overall Score</p>
@if ($results['total'] < 199)
                <p class="issues">Consider fixing the issues below to improve your overall mobile <br />score and help your SEO rankings and search metrics.</p>
@else
                <p class="issues">We could not find any technical issues with your website,<br />but could you optimise your site for more conversions?</p>
@endif
                <div class="phone_view">
                    <div class="screen">
                        <img src="{{ asset($results['screenshot']) }}" width="206" height="365" />
                    </div>
                    <div class="speed_score">
                        <p class="rating">Speed <span>{{ $results['ruleGroups']['SPEED']['score'] }}/100</span></p>
                    </div>
                    <div class="experience_score">
                        <p class="rating">User Experience <span class="ls_p">{{ $results['ruleGroups']['USABILITY']['score'] }}/100</span></p>
                    </div>
                    <div class="cro_score">
                        <p class="rating">CRO Review <span>??/100</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="white_section">
        <div class="content">
            <div class="analyze">
                <div class="rate_experience left">
                    <p class="score_title">User Experience <span class="span_ex_score">{{ $results['ruleGroups']['USABILITY']['score'] }} / 100</span></p>

                    <!-- Change the below data attribute to play -->
                    <div class="progress-wrap progress experience_progress" data-progress-percent="{{ $results['ruleGroups']['USABILITY']['score'] }}">
                        <div class="progress-bar progress"></div>
                    </div>

                </div>
                <div class="clear"></div>
<?php $last_impact = ''; $first = true; ?>

@if (isset($results['messages']['USABILITY']))
@foreach($results['messages']['USABILITY'] as $message)
@if (!$first)
    </p>
@endif
<?php $impact = what_type($message['ruleImpact']); ?>
@if ($impact !== $last_impact)
<?php echo impact_message($impact); $last_impact = $impact; $fist = false;?>
@endif

    <div class="fix_sugest">
        <p>{{$message['summary']}}</p>
    </div>
@endforeach
@endif

                <div class="rate_cro left">
                    <p class="score_title">Conversion Rate Optimisation <span class="span_cro_score">?? / 100</span></p>

                    <!-- Change the below data attribute to play -->
                    <div class="progress-wrap progress cro_progress" data-progress-percent="5">
                        <div class="progress-bar progress"></div>
                    </div>

                </div>
                <div class="clear"></div>
                <div class="info_cro">
                    <p>When it comes to maximising the return from your online marketing, conversion rate optimisation is arguably the single most important strategy you can use. But the fact is, if you’re not keeping your website visitors engaged, then chances are you’re not going to convert them - which means you could be losing out making the sales you need.</p>
                    <p>With our FREE Website Conversion Review - which is tailored to your business - we’ll assess and analyse your current CRO strategy. Once we understand your business goals and marketing objectives, we can then identify those areas you can tweak, enhance and improve.</p>
                </div>
                <div class="get_free">
                    <div class="ins_get_free">
                        <h4>Get Your Free Conversion Rate <br />Optimisation Review Now</h4>
                        <img class="red_arrow" src="images/red_arrow.png" />
                    </div>
                </div>
                <div class="rate_experience left">
                    <p class="score_title">Speed <span class="span_speed_score">{{ $results['ruleGroups']['SPEED']['score'] }} / 100</span></p>

                    <!-- Change the below data attribute to play -->
                    <div class="progress-wrap progress speed_progress" data-progress-percent="{{ $results['ruleGroups']['SPEED']['score'] }}">
                        <div class="progress-bar progress"></div>
                    </div>

                </div>
                <div class="clear"></div>
                <div class="">
                    <?php $last_impact = ''; $first = true; ?>

@if (isset($results['messages']['SPEED']))
                    @foreach($results['messages']['SPEED'] as $message)
                        @if (!$first)
                            </p>
                        @endif
                        <?php $impact = what_type($message['ruleImpact']); ?>
                        @if ($impact !== $last_impact)
                            <?php echo impact_message($impact); $last_impact = $impact; $fist = false;?>
                        @endif

                        <div class="fix_sugest">
                            <p>{{$message['summary']}}</p>
                        </div>
                    @endforeach
@endif

                </div>

                <div class="form_holder center">
                    <p>Turn more visitors into paying customers</p>
                    <h5>Get a FREE Website Conversion Review</h5>
                    <div class="red_line"></div>
                    @include('pagespeed.contact_form')
                </div>
            </div>

        </div>
    </div> <!--//white_section-->

    <div class="grey_section last_section center">
        <div class="content">
            <h4>Need help?</h4>
            <p>If you need help with your online marketing, then we'd love to chat.<br />Call us on 1800 932 776 or submit the form below.</p>
            <a class="get_in_touch" href="javascript:void(0);">Get In Touch</a>

            <div id="full-form" style="display: none;">
                @include('pagespeed.contact_form_site')
            </div>
        </div>
    </div>
</div> <!--//main_section-->


