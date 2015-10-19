<!-- Smart Wizard -->
<?php $uniqeId = uniqid(); ?>

<div class="col-md-12">
        <h1 class="text-center">MEDIA ACCREDITATION</h1>
        <h2 class="text-center" >Print Media</h2>
</div>
{!! Form::open(['route'=>'admin.media.reporter.store']) !!}
<div id="wizard" class="form_wizard wizard_horizontal">

    <ul class="wizard_steps" style="padding: 25px 0;">
        <li>
            <a href="#step-1">
                <span class="step_no">1</span>
                <span class="step_descr">
                    Page 1<br />
                    <small>Reporter Information</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#step-2">
                <span class="step_no">2</span>
                <span class="step_descr">
                    Page 2<br />
                    <small>Photo Journalist</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#step-3">
                <span class="step_no">3</span>
                    <span class="step_descr">
                    Page 3<br />
                    <small>Organization Information</small>
                </span>
            </a>
        </li>
    </ul>
    <div id="step-1">
        @include('blupl/franchises::print-media.franchises1')
    </div>
    <div id="step-2">
        @include('blupl/franchises::print-media.franchises2')
    </div>
    <div id="step-3">
        @include('blupl/franchises::print-media.franchises3')
    </div>
    {!! Form::hidden('organization[form_id]', $uniqeId) !!}


</div>
{!! Form::close() !!}
<!-- End SmartWizard Content -->