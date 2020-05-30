<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				VDM 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th May, 2020
	@created		20th September, 2017
	@package		Hello World
	@subpackage		greetings.php
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

use Joomla\Utilities\ArrayHelper;

/**
 * Greetings Controller
 */
class Hello_worldControllerGreetings extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_HELLO_WORLD_GREETINGS';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Greeting', $prefix = 'Hello_worldModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('greeting.export', 'com_hello_world') && $user->authorise('core.export', 'com_hello_world'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Greetings');
			// get the data to export
			$data = $model->getExportData($pks);
			if (Hello_worldHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				Hello_worldHelper::xls($data,'Greetings_'.$date->format('jS_F_Y'),'Greetings exported ('.$date->format('jS F, Y').')','greetings');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_HELLO_WORLD_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_hello_world&view=greetings', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('greeting.import', 'com_hello_world') && $user->authorise('core.import', 'com_hello_world'))
		{
			// Get the import model
			$model = $this->getModel('Greetings');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (Hello_worldHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('greeting_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'greetings');
				$session->set('dataType_VDM_IMPORTINTO', 'greeting');
				// Redirect to import view.
				$message = JText::_('COM_HELLO_WORLD_IMPORT_SELECT_FILE_FOR_GREETINGS');
				$this->setRedirect(JRoute::_('index.php?option=com_hello_world&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_HELLO_WORLD_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_hello_world&view=greetings', false), $message, 'error');
		return;
	}
}
