<?php

class MoriageController
{
	public function moriage($bot, $event)
	{
		$getText = $event->getText();
		foreach (MoriageArray as $key => $value){
			if ($getText == $key){
				$bot->replyText($event->getReplyToken(), $value);
				break;
			}
		}
	}
}

?>