<?php
namespace WeWork\Model\Message;

use WeWork\Error\QyApiError;
use WeWork\Util\Utils;

class NewsMessageContent
{
	public $msgtype = "news";
	public $articles = null; // NewsArticle array
	
	public function __construct($articles)
	{
		$this->articles = $articles;
	}
	
	public function CheckMessageSendArgs()
	{
		$size = count($this->articles);
		if ($size < 1 || $size > 8) throw new QyApiError("1~8 articles should be given");
		
		foreach($this->articles as $item) {
			$item->CheckMessageSendArgs();
		}
	}
	
	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);
		
		$articleList = array();
		foreach($this->articles as $item) {
			$articleList[] = $item->Article2Array();
		}
		$arr[$this->msgtype]["articles"] = $articleList;
	}
}