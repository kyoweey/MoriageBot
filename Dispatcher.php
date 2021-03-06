<?php

class Dispatcher
{
	public function dispatch()
	{
		$controllerInstance = moriageControllerFactory::create();
		// アクセストークンを使いCurlHTTPClientをインスタンス化
		$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

		// CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
		$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

		// LINE Messaging APIがリクエストに付与した署名を取得
		$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
		// 署名が正当化チェック。政党であればリクエストをパースし配列へ。不正であれば例外の内容を出力。
		try {
			$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
		} catch (\LINE\LINEBot\Exception\InvalidSignatureException $e) {
			error_log('parseEventRequest failed. InvalidSignatureException =>' . var_export($e, true));
		} catch (\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
			error_log('parseEventRequest failed. UnknownEventTypeException =>' . var_export($e, true));
		} catch (\LINE\LINEBot\Exception\unknownMessageTypeException $e) {
			error_log('parseEventRequest failed. UnknownMessageTypeException =>' . var_export($e, true));
		} catch (\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
			error_log('parseEventRequest failed. InvalidEventRequestException =>' . var_export($e, true));
		}

		// 配列に格納された各イベントをループで処理
		foreach ($events as $event) {
			// MessageEventクラスのインスタンスでなければスキップ
			if (!($event instanceOf \LINE\LINEBot\Event\MessageEvent)) {
				error_log('Non message event has come');
				continue;
			}
			// TextMessageクラスのインスタンスでなければ処理をスキップ
			if (!($event instanceOf \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
				error_log('Non text message event has come');
				continue;
			}

			$controllerInstance->moriage($bot, $event);
		}
	}
}

?>