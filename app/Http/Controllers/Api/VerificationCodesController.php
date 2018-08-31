<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;

        // 生产4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4,0, STR_PAD_LEFT);

        try {
            $result = $easySms->send($phone, [
                'content'  =>  "【SDLBBS社区】您的验证码是{$code}。如非本人操作，请忽略本短信"
            ]);
        } catch () {

        }
    }
}