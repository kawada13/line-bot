<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
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




        $replay_message = new TextMessageBuilder('hello');
        $replay_stamp = new StickerMessageBuilder(1070, 17841);
        $replay_audio = new AudioMessageBuilder("https://res.cloudinary.com/code-kitchen/video/upload/v1555038697/posts/zk5sldkxuebny7mwlhh3.mp3", 20000);





        $lineBot->replyMessage($reply_token, $replay_audio);

    }
}