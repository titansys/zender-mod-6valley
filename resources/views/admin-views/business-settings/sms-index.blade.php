@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('SMS Module Setup'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{\App\CPU\translate('3rd_party')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.third-party-inline-menu')
        <!-- End Inlile Menu -->

        <div class="row gy-3">
            <div class="col-md-6">
                {{--
                    Zender Gateway Settings
                    Please note that this form was not localized
                 --}}

                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Zender</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('zender_gateway'))
                        <form action="{{route('admin.business-settings.sms-module-update', ['zender_gateway'])}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">Zender</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('inactive')}} </label>

                            </div>

                            <div class="form-group">
                                <label class="text-capitalize form-label">Site URL</label>
                                <br>
                                <small>The site url of your Zender. Do not add ending slash.</small>
                                <input type="text" class="form-control" name="site_url" value=" {{$config['site_url'] ?: ""}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">API Key</label>
                                <br>
                                <small>Your API key. Please make sure that everything is correct and required permissions are granted: sms_send, wa_send</small>
                                <input type="text" class="form-control" name="api_key" value="{{$config['api_key'] ?: ""}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">Sending Service</label>
                                <br>
                                <small>Select the sending service. Please make sure that the API key has the following permissions: sms_send, wa_send</small>
                                <select class="form-control" name="service">
                                    <option value="1" {{$config['service'] < 2 ? "selected" : false}}>SMS</option>
                                    <option value="2" {{$config['service'] > 1 ? "selected" : false}}>WhatsApp</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="title-color">WhatsApp Account ID</label><br>
                                <small>For WhatsApp service only. WhatsApp account ID you want to use for sending.</small>
                                <input type="text" class="form-control" name="whatsapp" value="{{$config['whatsapp'] ?: ""}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">Device Unique ID</label><br>
                                <small>For SMS service only. Linked device unique ID. Please only enter this field if you are sending using one of your devices.</small>
                                <input type="text" class="form-control" name="device" value="{{$config['device'] ?: ""}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">Gateway Unique ID</label><br>
                                <small>For SMS service only. Partner device unique ID or gateway ID. Please only enter this field if you are sending using a partner device or third party gateway.</small>
                                <input type="text" class="form-control" name="gateway" value="{{$config['gateway'] ?: ""}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">Sim Slot</label><br>
                                <small>For SMS service only. Select the sim slot you want to use for sending the messages. Please only enter this field if you are sending using a partner device or third party gateway. This is ignored for partner devices and third party gateways.</small>
                                <select class="form-control" name="slot">
                                    <option value="sim1" {{$config['slot'] == "sim1" ? "selected" : false}}>SIM 1</option>
                                    <option value="sim2" {{$config['slot'] == "sim2" ? "selected" : false}}>SIM 2</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{$config['otp_template'] ?: ""}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary px-4">{{\App\CPU\translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('releans_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('releans_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['releans_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\translate('releans_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('inactive')}} </label>

                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('from')}}</label>
                                <input type="text" class="form-control" name="from"
                                       value="{{env('APP_MODE')!='demo'?$config['from']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary px-4">{{\App\CPU\translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('twilio_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('twilio_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['twilio_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf
                            <label class="mb-3 d-block title-color">{{\App\CPU\translate('twilio_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\translate('sid')}}</label>
                                <input type="text" class="form-control" name="sid"
                                       value="{{env('APP_MODE')!='demo'?$config['sid']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\translate('messaging_service_sid')}}</label>
                                <input type="text" class="form-control" name="messaging_service_sid"
                                       value="{{env('APP_MODE')!='demo'?$config['messaging_service_sid']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('token')}}</label>
                                <input type="text" class="form-control" name="token"
                                       value="{{env('APP_MODE')!='demo'?$config['token']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('from')}}</label>
                                <input type="text" class="form-control" name="from"
                                       value="{{env('APP_MODE')!='demo'?$config['from']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary px-4">{{\App\CPU\translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('nexmo_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('nexmo_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['nexmo_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\translate('nexmo_sms')}}</label>


                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('active')}}</label>

                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize"
                                       class="title-color">{{\App\CPU\translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('api_secret')}}</label>
                                <input type="text" class="form-control" name="api_secret"
                                       value="{{env('APP_MODE')!='demo'?$config['api_secret']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('from')}}</label>
                                <input type="text" class="form-control" name="from"
                                       value="{{env('APP_MODE')!='demo'?$config['from']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                            </div>
                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary px-4">{{\App\CPU\translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('2factor_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <div class="mb-3 d-flex flex-wrap gap-10">
                            <span class="badge text-wrap badge-soft-info">{{\App\CPU\translate("EX of SMS provider's template : your OTP is XXXX here, please check")}}.</span>
                            <span class="badge text-wrap badge-soft-info">{{\App\CPU\translate('NB : XXXX will be replace with otp')}}</span>
                        </div>

                        @php($config=\App\CPU\Helpers::get_business_settings('2factor_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['2factor_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\translate('2factor_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary px-4">{{\App\CPU\translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\translate('msg91_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">{{\App\CPU\translate('NB : Keep an OTP variable in your SMS providers OTP Template')}}.</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('msg91_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['msg91_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\translate('msg91_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('active')}}</label>

                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\translate('inactive')}} </label>

                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\translate('template_id')}}</label>
                                <input type="text" class="form-control" name="template_id"
                                       value="{{env('APP_MODE')!='demo'?$config['template_id']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\translate('authkey')}}</label>
                                <input type="text" class="form-control" name="authkey"
                                       value="{{env('APP_MODE')!='demo'?$config['authkey']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary px-4">{{\App\CPU\translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush