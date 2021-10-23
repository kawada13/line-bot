<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Exception;

class LineController extends Controller
{
    public function webhook (Request $request)
    {
        $lineAccessToken = env('LINE_ACCESS_TOKEN', "");
        $lineChannelSecret = env('LINE_CHANNEL_SECRET', "");

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($lineAccessToken);
        $lineBot = new \LINE\LINEBot($httpClient, ['channelSecret' => $lineChannelSecret]);

        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);

        $events = $lineBot->parseEventRequest($request->getContent(), $signature);
        $event = $events[0];



        $reply_token = $event->getReplyToken();
        $reply_text = $event->getText();
        $lineBot->replyText($reply_token, $reply_text);

    }
}