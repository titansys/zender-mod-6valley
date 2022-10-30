<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SMSModuleController extends Controller
{
    public function sms_index()
    {
        return view('admin-views.business-settings.sms-index');
    }

    public function sms_update(Request $request, $module)
    {
        if ($module == 'twilio_sms') {
            DB::table('business_settings')->updateOrInsert(['type' => 'twilio_sms'], [
                'type' => 'twilio_sms',
                'value' => json_encode([
                    'status' => $request['status'],
                    'sid' => $request['sid'],
                    'messaging_service_sid' => $request['messaging_service_sid'],
                    'token' => $request['token'],
                    'from' => $request['from'],
                    'otp_template' => $request['otp_template'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($module == 'nexmo_sms') {
            DB::table('business_settings')->updateOrInsert(['type' => 'nexmo_sms'], [
                'type' => 'nexmo_sms',
                'value' => json_encode([
                    'status' => $request['status'],
                    'api_key' => $request['api_key'],
                    'api_secret' => $request['api_secret'],
                    'signature_secret' => '',
                    'private_key' => '',
                    'application_id' => '',
                    'from' => $request['from'],
                    'otp_template' => $request['otp_template']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($module == '2factor_sms') {
            DB::table('business_settings')->updateOrInsert(['type' => '2factor_sms'], [
                'type' => '2factor_sms',
                'value' => json_encode([
                    'status' => $request['status'],
                    'api_key' => $request['api_key'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($module == 'msg91_sms') {
            DB::table('business_settings')->updateOrInsert(['type' => 'msg91_sms'], [
                'type' => 'msg91_sms',
                'value' => json_encode([
                    'status' => $request['status'],
                    'template_id' => $request['template_id'],
                    'authkey' => $request['authkey'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($module == 'releans_sms') {
            DB::table('business_settings')->updateOrInsert(['type' => 'releans_sms'], [
                'type' => 'releans_sms',
                'value' => json_encode([
                    'status' => $request['status'],
                    'api_key' => $request['api_key'],
                    'from' => $request['from'],
                    'otp_template' => $request['otp_template']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($module == 'zender_gateway') {
            DB::table('business_settings')->updateOrInsert(['key' => 'zender_gateway'], [
                'key' => 'zender_gateway',
                'value' => json_encode([
                    'status' => $request['status'],
                    'site_url' => $request['site_url'],
                    'api_key' => $request['api_key'],
                    'service' => $request['service'],
                    'whatsapp' => $request['whatsapp'],
                    'device' => $request['device'],
                    'gateway' => $request['gateway'],
                    'slot' => $request['slot'],
                    'otp_template' => $request['otp_template'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($request['status'] == 1) {
            $config = Helpers::get_business_settings('twilio_sms');
            if (isset($config) && $module != 'twilio_sms') {
                DB::table('business_settings')->updateOrInsert(['type' => 'twilio_sms'], [
                    'type' => 'twilio_sms',
                    'value' => json_encode([
                        'status' => 0,
                        'sid' => $config['sid'],
                        'token' => $config['token'],
                        'from' => $config['from'],
                        'otp_template' => $config['otp_template'],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $config = Helpers::get_business_settings('nexmo_sms');
            if (isset($config) && $module != 'nexmo_sms') {
                DB::table('business_settings')->updateOrInsert(['type' => 'nexmo_sms'], [
                    'type' => 'nexmo_sms',
                    'value' => json_encode([
                        'status' => 0,
                        'api_key' => $config['api_key'],
                        'api_secret' => $config['api_secret'],
                        'signature_secret' => '',
                        'private_key' => '',
                        'application_id' => '',
                        'from' => $config['from'],
                        'otp_template' => $config['otp_template']
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $config = Helpers::get_business_settings('2factor_sms');
            if (isset($config) && $module != '2factor_sms') {
                DB::table('business_settings')->updateOrInsert(['type' => '2factor_sms'], [
                    'type' => '2factor_sms',
                    'value' => json_encode([
                        'status' => 0,
                        'api_key' => $config['api_key'],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $config = Helpers::get_business_settings('msg91_sms');
            if (isset($config) && $module != 'msg91_sms') {
                DB::table('business_settings')->updateOrInsert(['type' => 'msg91_sms'], [
                    'type' => 'msg91_sms',
                    'value' => json_encode([
                        'status' => 0,
                        'template_id' => $config['template_id'],
                        'authkey' => $config['authkey'],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $config = Helpers::get_business_settings('releans_sms');
            if (isset($config) && $module != 'releans_sms') {
                DB::table('business_settings')->updateOrInsert(['type' => 'releans_sms'], [
                    'type' => 'releans_sms',
                    'value' => json_encode([
                        'status' => 0,
                        'api_key' => $request['api_key'],
                        'from' => $request['from'],
                        'otp_template' => $request['otp_template']
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $config = Helpers::get_business_settings('zender_gateway');
            if ($module != 'zender_gateway') {
                DB::table('business_settings')->updateOrInsert(['key' => 'zender_gateway'], [
                    'key' => 'zender_gateway',
                    'value' => json_encode([
                        'status' => 0,
                        'site_url' => $config['site_url'],
                        'api_key' => $config['api_key'],
                        'service' => $config['service'],
                        'whatsapp' => $config['whatsapp'],
                        'device' => $config['device'],
                        'gateway' => $config['gateway'],
                        'slot' => $config['slot'],
                        'otp_template' => $config['otp_template'],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back();
    }
}