<?php

class moriageController
{
	public function moriage($bot, $event)
	{
		$getText = $event->getText();
		foreach ($moriageArray as $key => $value){
			if ($getText == $key){
				$bot->replyText($event->getReplyToken(), $value);
				break;
			}
		}
	}
}

?>