<?php

namespace Habib\Payout\Http\Controllers;

use Habib\Payout\Events\HyperSplitWebhookEvent;
use Illuminate\Http\Request;

class HyperSplitWebhookController extends Controller
{
    public function __invoke(Request $request)
    {

        $key_from_configuration = config('payout.hyper_split.notification_key');
        $iv_from_http_header = $request->header('x-initialization-vector');
        $auth_tag_from_http_header = $request->header('x-authentication-tag');
        $http_body = $request->get('encryptedBody');

        $key = hex2bin($key_from_configuration);
        $iv = hex2bin($iv_from_http_header);
        $auth_tag = hex2bin($auth_tag_from_http_header);
        $cipher_text = hex2bin($http_body);

        $result = json_decode(openssl_decrypt($cipher_text, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $auth_tag), true);
        if ($result && $result['status']) {
            foreach ($result['data']['transactions'] ?? [] as $transaction) {
                event(new HyperSplitWebhookEvent($transaction));
            }

            return response()->json(['key' => 'success', 'msg' => 'Done']);

        }
        return response()->json(['key' => 'fail', 'msg' => 'failed', 'result' => $result]);

    }
}
