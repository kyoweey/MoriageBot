<?php

class Reply 
{
	public static $reply;

	// テキストを返信。引数はLINEBot、返信先、テキスト
	public function replyTextMessage($bot, $replyToken, $text) {
		// 返信を行いレスポンスを取得
		// TextMessageBuilderの引数はテキスト
		$response = $bot -> replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));

		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}
	}

	// 画像を返信。引数はLINEBot、返信先、画像URL、サムネイルURL
	public function replyImageMassage($bot, $replyToken, $originalImageUrl, $previewImageUrl) {
		// ImageMessageBulderの引数は、画像URL、サムネイルURL
		$response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalImageUrl, $previewImageUrl));

		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}
	}

	// 位置情報を返信。引数はLINEBot、返信先、タイトル、住所、緯度、経度
	public function replyLocationMessage($bot, $replyToken, $title, $address, $lat, $lon) {
		// LocationMessageBuiderの引数はダイアログのタイトル、住所、経度、緯度
		$response = $bot -> replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder($title, $address, $lat, $lon));

		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}	
	}

	// スタンプを返信。引数はLINEBot、返信先、スタンプのパッケージID、スタンプID
	public function replyStickerMessage($bot, $replyToken, $packageId, $stickerId) {
		// StickerMessageBuilderの引数は　スタンプのパッケージID、スタンプID
		$response = $bot -> replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\StickerMessageBuider($packageId, $stickerId));

		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}
	}

	// 動画を返信。引数は　LINEBot、返信先、動画URL、サムネイルURL
	public function replyVideoMessage($bot, $replyToken, $originalContentUrl, $previewImageUrl) {
		// VideoMessageBuilderの引数は、動画URL、サムネイルURL
		$response = $bot -> replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($originalContentUrl, $previewImageUrl));

		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}	
	}

	// オーディオファイルを返信。引数はLINEBot、返信先、ファイルのURL、ファイルの再生時間
	public function replyAudioMessage($bot, $replyToken, $originalContentUrl, $audioLength) {
		// AudioMessageBuilderの引数はファイルのURL、ファイルの再生時間
		$response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\AudioMessageBuilder($originalContentUrl, $audioLength));

		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}
	}

	// 複数のメッセージをまとめて返信。引数はLINEBot、返信先、メッセージ(可変長引数)
	public function replyMultiMessage($bot, $replyToken, ...$msgs) {
		// MultiMessageBuilderをインスタンス化
		$builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		//ビルダーにメッセージを全て追加
		foreach ($msgs as $value) {
			$builder->add($value);
		}
		$response = $bot->replyMessage($replyToken, $builder);
		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}		
	}

	// Buttonsテンプレートを返信。引数はLINEBot、返信先、テキスト、画像URL、タイトル、本文、アクション(可変長引数)
	public function replyButtonsTemplate($bot, $replyToken, $alternativeText, $imageUrl, $title, $text, ...$actions) {

		// アクションを格納する配列
		$actionArray = array();
		// アクションを全て追加
		foreach ($actions as $value) {
			array_push($actionArray, $value);
		}
		// TemplateMessageBuilderの引数は代替テキスト、ButtonTemplateBuilder
		$builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,
			// ButtonTemplateBuilderの引数はタイトル、本文、画像URL、アクションの配列
			new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder($title, $text, $imageUrl, $actionArray)
		);
		$response = $bot->replyMessage($replyToken, $builder);
		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}		
	}

	// Confirmテンプレートを返信。引数はLINEBot、返信先、代替テキスト、本文、アクション(可変長)
	public function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {
		$actionArray = array();
		foreach ($actions as $value) {
			array_push($actionArray, $value);
		}
		$builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,
			// Confirmテンプレートの引数はテキスト、アクションの配列
			new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder($text, $actionArray)
		);
		$response = $bot->replyMessage($replyToken, $builder);
		if (!$response->isSucceeded()) {
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}	
	}

	// Carouselテンプレートを返信。引数はLINEBot、返信先、代替テキスト、ダイアログの配列
	public function replyCarouselTemplate($bot, $replyToken, $alternativeText, $coulmnArray) {
		$builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,
			// Carouselテンプレートの引数はダイアログの配列
			new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder ($coulmnArray)
		);
		$response = $bot->replyMessage($replyToken, $builder);
		// レスポンスが以上な場合
		if (!$response->isSucceeded()) {
			// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}	
	}
}

?>