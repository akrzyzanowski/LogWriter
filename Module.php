<?php
/**
 * This is ZF2 module to create and storage events logs in database
 * 
 * you can find database structure in file 'database-structure.sql'  
 * 
 * @author		akrzyzanowski
 * @copyright	akrzyzanowski
 * 
 * @example	how to use this module from controller
 * 
 * 		// add new information log
 *		$this->getServiceLocator()->get('LogWriter')->addInfoLog($title,$message,$file);   	
 * 
 *		// get logs (default 100 positions) 
 * 		$this->getServiceLocator()->get('LogWriter')->getLogs();   	
 * 
 */

namespace LogWriter;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;

use LogWriter\Model\Log;
use LogWriter\Model\Tables\LogsTable;
use LogWriter\Service\LogWriter;

class Module implements BootstrapListenerInterface, AutoloaderProviderInterface, ConfigProviderInterface {
	
	public function onBootstrap(EventInterface $e) {
		$eventManager        = $e->getApplication()->getEventManager();
		$eventManager->attach('dispatch', array($this, 'loadConfiguration' ), 100);
	
		$eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleDispatchError'));
		$eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleRenderError'));
	}
	
	public function handleDispatchError(MvcEvent $e) {
		$exception = $e->getParam('exception');
		if ($exception) $e->getApplication()->getServiceManager()->get('LogWriter')->addErrorLog('Dispatch Error',$exception->getMessage(),$exception->getFile().' ('.$exception->getLine().')');
	}
	
	public function handleRenderError(MvcEvent $e) {
		$exception = $e->getParam('exception');
		$e->getApplication()->getServiceManager()->get('LogWriter')->addErrorLog('Render Error',$exception->getMessage(),$exception->getFile().' ('.$exception->getLine().')');
	}
	
	public function loadConfiguration(MvcEvent $e) {
		$sm  = $e->getApplication()->getServiceManager();
			
		$controller = $e->getRouteMatch()->getParam('controller');
		
		if (0 !== strpos($controller, __NAMESPACE__, 0)) return;
			
		$exceptionstrategy = $sm->get('ViewManager')->getExceptionStrategy();
		$exceptionstrategy->setExceptionTemplate('error/admin');	
	}
	
	public function getAutoloaderConfig() {
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
	
	public function getConfig()	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig() {
		return array(
			'factories' => array(
				'LogWriter\Model\Tables\LogsTable' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Log());
					return new LogsTable(new TableGateway('logs', $dbAdapter, null, $resultSetPrototype));
				},
				
				'logWriter' => function($sm) {
					return new LogWriter($sm);				 
				},
			),
		);
	}


}
