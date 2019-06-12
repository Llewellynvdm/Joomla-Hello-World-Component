<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				VDM 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th June, 2019
	@created		20th September, 2017
	@package		Hello World
	@subpackage		hello_world.php
	@author			Llewellyn <https://www.vdm.io>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tabstate');

// Set the component css/js
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_hello_world/assets/css/site.css');
$document->addScript('components/com_hello_world/assets/js/site.js');

// Require helper files
JLoader::register('Hello_worldHelper', __DIR__ . '/helpers/hello_world.php'); 
JLoader::register('Hello_worldHelperRoute', __DIR__ . '/helpers/route.php'); 

// Get an instance of the controller prefixed by Hello_world
$controller = JControllerLegacy::getInstance('Hello_world');

// Perform the request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
