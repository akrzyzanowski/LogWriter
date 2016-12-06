<?php
namespace LogWriter\Service;

use LogWriter\Model\Log;

class LogWriter {	
	
	protected $sm;									// service menager
	protected $logsTable;							// tablegateway with logs
	
	public function __construct($sm) {
		$this->sm = $sm;	
	}
	
	/**
	 * add information log
	 * 
	 * @param 	VARCHAR $topic						// log topic
	 * @param 	VARCHAR $message	(null)			// log message
	 * @param 	VARCHAR $file		(null)			// log file
	 * 
	 * @author	akrzyzanowski
	 */
	public function addInfoLog($topic, $message = null, $file = null) {	
		$this->addLog($topic, $message, $file, $type = 0);
	}
	
	/**
	 * add edit log
	 *
	 * @param 	VARCHAR $topic						// log topic
	 * @param 	VARCHAR $message	(null)			// log message
	 * @param 	VARCHAR $file		(null)			// log file
	 * 
	 * @author	akrzyzanowski
	 */
	public function addEditLog($topic, $message = null, $file = null) {
		$this->addLog($topic, $message, $file, $type = 1);
	}
	
	/**
	 * add warning log
	 *
	 * @param 	VARCHAR $topic						// log topic
	 * @param 	VARCHAR $message	(null)			// log message
	 * @param 	VARCHAR $file		(null)			// log file
	 * 
	 * @author	akrzyzanowski
	 */
	public function addWarningLog($topic, $message = null, $file = null) {
		$this->addLog($topic, $message, $file, $type = 2);
	}
	
	/**
	 * add error log
	 *
	 * @param 	VARCHAR $topic						// log topic
	 * @param 	VARCHAR $message	(null)			// log message
	 * @param 	VARCHAR	$file		(null)			// log file
	 * 
	 * @author	akrzyzanowski
	 */
	public function addErrorLog($topic, $message = null, $file = null) {
		$this->addLog($topic, $message, $file, $type = 3);
	}

	/**
	 * get events logs from database
	 *
	 * @param 	STRING	$where					// Additional SQL where clause (example 'id = 1')
	 * @param 	INT		$limit 	(100)			// rows limit
	 *
	 * @return 	$results
	 *
	 * @author	akrzyzanowski
	 */
	public function getLogs($where = '', $limit = 100) {
		return $this->getLogsTable()->getRows($where,'id DESC',$limit);
	}
	
	
	
	/********************************
	 *
	 * 		PROTECTED FUNCTIONS
	 *
	 ********************************/
	
	
	/**
	 * function create and insert new log
	 *
	 * @param 	VARCHAR $topic					// log topic
	 * @param 	VARCHAR $message	(null)		// log message
	 * @param 	VARCHAR $file		(null)		// log file
	 * @param 	TINYINT $type		(0)			// log type
	 * 
	 * @throws	\Exception
	 * 
	 * @author	akrzyzanowski
	 */
	protected function addLog($topic, $message = null, $file = null, $type = 0) {
	
		$log = new Log();
	
		$log->title = $topic;			
		$log->url = $this->sm->get('request')->getUriString();		
		$log->message = $message;
		$log->file = $file;
		$log->type = $type;
	
		try {
			$this->getLogsTable()->saveItem($log);
		} catch (\Exception $ex) {
			throw new \Exception('There was a problem with creating a new record in the logs table');
		}
	}
	
	/**
	 * get Logs TableGateway
	 *
	 * @return	TableGateway $this->logsTable 
	 * 
	 * @author	akrzyzanowski
	 */
	protected function getLogsTable() {
		if (!$this->logsTable) 
			$this->logsTable = $this->sm->get('LogWriter\Model\Tables\LogsTable');
		return $this->logsTable;
	}
}
