<?php
namespace LogWriter\Model;

class Log {
	
	public $id;				//	INT		 		id
	public $date;			//	DATETIME 		event date
	public $title;			//	VARCHAR	 		event title
	public $url;			//	VARCHAR	 		event url
	public $message;		//	VARCHAR	 		event message
	public $file;			//	VARCHAR	 		event file
	public $type;			//	TINYINT	 		event type ( 0 - information | 1 - edit | 2 - warning | 3 - error )     
  
	public function exchangeArray($data) {
		$this->id		= (!empty($data['id'])) ? $data['id'] : null;     
		$this->date		= (!empty($data['date'])) ? $data['date'] : null;
		$this->title	= (!empty($data['title'])) ? $data['title'] : null;
		$this->url		= (!empty($data['url'])) ? $data['url'] : null;
		$this->message	= (!empty($data['message'])) ? $data['message'] : null;
		$this->file		= (!empty($data['file'])) ? $data['file'] : null;
		$this->type		= (!empty($data['type'])) ? $data['type'] : null;
	}
}
