<?php
namespace LogWriter\Model\Tables;

use Zend\Db\TableGateway\TableGateway;
use LogWriter\Model\Log;

class LogsTable extends TableGateway {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}	
	
	/**
	 * get rows from database
	 *
	 * @param	STRING	$where 	(null)			// Additional SQL where clause (example 'id = 1')
	 * @param	STRING	$order 	('id DESC')		// Additional SQL order clause (example 'id DESC')
	 * @param	INT		$limit 	(null)			// Additional SQL limit clause (example (int) 100)
	 * @param	INT		$offset (null)			// Additional SQL offset clause (example (int) 10)
	 * 
	 * @return	$results
	 * 
	 * @author	akrzyzanowski
	 */
	public function getRows($where = null, $order = 'id DESC', $limit = null, $offset = null) {
	
		$select = $this->tableGateway->getSql()->select();	
		
		$select->columns(array('*'),true);
	
		if ($where) $select->where($where);
	
		if ($order) $select->order($order);
	
		if ($limit) $select->limit($limit);
	
		if ($offset) $select->offset($offset);
	
		return $this->tableGateway->selectWith($select);
	}
	
	/**
	 * insert new log
	 * 
	 * @param	Log $log		// Log model to save
	 * 
	 * @author	akrzyzanowski
	 */
	public function saveItem(Log $log) {
		
		$data = array(			
			'title'			=> $log->title,
			'url'			=> $log->url,
			'message'		=> $log->message,
			'file'			=> $log->file,
			'type'			=> $log->type,		
		);
		
		$this->tableGateway->insert($data);
	}
}
