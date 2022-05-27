<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				VDM 
/-------------------------------------------------------------------------------------------------------/

	@version		1.1.0
	@build			27th May, 2022
	@created		20th September, 2017
	@package		Hello World
	@subpackage		script.php
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

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Installer\Adapter\ComponentAdapter;
JHTML::_('bootstrap.renderModal');

/**
 * Script File of Hello_world Component
 */
class com_hello_worldInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 */
	public function __construct(ComponentAdapter $parent) {}

	/**
	 * Called on installation
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(ComponentAdapter $parent) {}

	/**
	 * Called on uninstallation
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 */
	public function uninstall(ComponentAdapter $parent)
	{
		// Get Application object
		$app = JFactory::getApplication();

		// Get The Database object
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select ids from fields
		$query->select($db->quoteName('id'));
		$query->from($db->quoteName('#__fields'));
		// Where greeting context is found
		$query->where( $db->quoteName('context') . ' = '. $db->quote('com_hello_world.greeting') );
		$db->setQuery($query);
		// Execute query to see if context is found
		$db->execute();
		$greeting_found = $db->getNumRows();
		// Now check if there were any rows
		if ($greeting_found)
		{
			// Since there are load the needed  greeting field ids
			$greeting_field_ids = $db->loadColumn();
			// Remove greeting from the field table
			$greeting_condition = array( $db->quoteName('context') . ' = '. $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__fields'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove greeting add queued success message.
				$app->enqueueMessage(JText::_('The fields with type (com_hello_world.greeting) context was removed from the <b>#__fields</b> table'));
			}
			// Also Remove greeting field values
			$greeting_condition = array( $db->quoteName('field_id') . ' IN ('. implode(',', $greeting_field_ids) .')');
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__fields_values'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove greeting field values
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove greeting add queued success message.
				$app->enqueueMessage(JText::_('The fields values for greeting was removed from the <b>#__fields_values</b> table'));
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select ids from field groups
		$query->select($db->quoteName('id'));
		$query->from($db->quoteName('#__fields_groups'));
		// Where greeting context is found
		$query->where( $db->quoteName('context') . ' = '. $db->quote('com_hello_world.greeting') );
		$db->setQuery($query);
		// Execute query to see if context is found
		$db->execute();
		$greeting_found = $db->getNumRows();
		// Now check if there were any rows
		if ($greeting_found)
		{
			// Remove greeting from the field groups table
			$greeting_condition = array( $db->quoteName('context') . ' = '. $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__fields_groups'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove greeting add queued success message.
				$app->enqueueMessage(JText::_('The field groups with type (com_hello_world.greeting) context was removed from the <b>#__fields_groups</b> table'));
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where greeting alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$greeting_found = $db->getNumRows();
		// Now check if there were any rows
		if ($greeting_found)
		{
			// Since there are load the needed  greeting type ids
			$greeting_ids = $db->loadColumn();
			// Remove greeting from the content type table
			$greeting_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove greeting add queued success message.
				$app->enqueueMessage(JText::_('The (com_hello_world.greeting) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove greeting items from the contentitem tag map table
			$greeting_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove greeting add queued success message.
				$app->enqueueMessage(JText::_('The (com_hello_world.greeting) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove greeting items from the ucm content table
			$greeting_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully removed greeting add queued success message.
				$app->enqueueMessage(JText::_('The (com_hello_world.greeting) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the greeting items are cleared from DB
			foreach ($greeting_ids as $greeting_id)
			{
				// Remove greeting items from the ucm base table
				$greeting_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $greeting_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($greeting_condition);
				$db->setQuery($query);
				// Execute the query to remove greeting items
				$db->execute();

				// Remove greeting items from the ucm history table
				$greeting_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $greeting_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($greeting_condition);
				$db->setQuery($query);
				// Execute the query to remove greeting items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Greeting alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$greeting_found = $db->getNumRows();
		// Now check if there were any rows
		if ($greeting_found)
		{
			// Since there are load the needed  greeting type ids
			$greeting_ids = $db->loadColumn();
			// Remove Greeting from the content type table
			$greeting_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove Greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove Greeting add queued success message.
				$app->enqueueMessage(JText::_('The (com_hello_world.greeting) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Greeting items from the contentitem tag map table
			$greeting_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove Greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully remove Greeting add queued success message.
				$app->enqueueMessage(JText::_('The (com_hello_world.greeting) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Greeting items from the ucm content table
			$greeting_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_hello_world.greeting') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($greeting_condition);
			$db->setQuery($query);
			// Execute the query to remove Greeting items
			$greeting_done = $db->execute();
			if ($greeting_done)
			{
				// If successfully removed Greeting add queued success message.
				$app->enqueueMessage(JText::_('The (com_hello_world.greeting) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Greeting items are cleared from DB
			foreach ($greeting_ids as $greeting_id)
			{
				// Remove Greeting items from the ucm base table
				$greeting_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $greeting_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($greeting_condition);
				$db->setQuery($query);
				// Execute the query to remove Greeting items
				$db->execute();

				// Remove Greeting items from the ucm history table
				$greeting_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $greeting_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($greeting_condition);
				$db->setQuery($query);
				// Execute the query to remove Greeting items
				$db->execute();
			}
		}

		// If All related items was removed queued success message.
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_base</b> table'));
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_history</b> table'));

		// Remove hello_world assets from the assets table
		$hello_world_condition = array( $db->quoteName('name') . ' LIKE ' . $db->quote('com_hello_world%') );

		// Create a new query object.
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__assets'));
		$query->where($hello_world_condition);
		$db->setQuery($query);
		$greeting_done = $db->execute();
		if ($greeting_done)
		{
			// If successfully removed hello_world add queued success message.
			$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));
		}


		// Set db if not set already.
		if (!isset($db))
		{
			$db = JFactory::getDbo();
		}
		// Set app if not set already.
		if (!isset($app))
		{
			$app = JFactory::getApplication();
		}
		// Remove Hello_world from the action_logs_extensions table
		$hello_world_action_logs_extensions = array( $db->quoteName('extension') . ' = ' . $db->quote('com_hello_world') );
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__action_logs_extensions'));
		$query->where($hello_world_action_logs_extensions);
		$db->setQuery($query);
		// Execute the query to remove Hello_world
		$hello_world_removed_done = $db->execute();
		if ($hello_world_removed_done)
		{
			// If successfully remove Hello_world add queued success message.
			$app->enqueueMessage(JText::_('The com_hello_world extension was removed from the <b>#__action_logs_extensions</b> table'));
		}

		// Set db if not set already.
		if (!isset($db))
		{
			$db = JFactory::getDbo();
		}
		// Set app if not set already.
		if (!isset($app))
		{
			$app = JFactory::getApplication();
		}
		// Remove Hello_world Greeting from the action_log_config table
		$greeting_action_log_config = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_hello_world.greeting') );
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__action_log_config'));
		$query->where($greeting_action_log_config);
		$db->setQuery($query);
		// Execute the query to remove com_hello_world.greeting
		$greeting_action_log_config_done = $db->execute();
		if ($greeting_action_log_config_done)
		{
			// If successfully removed Hello_world Greeting add queued success message.
			$app->enqueueMessage(JText::_('The com_hello_world.greeting type alias was removed from the <b>#__action_log_config</b> table'));
		}
		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:joomla@vdm.io">joomla@vdm.io</a>.
		<br />We at VDM are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="https://www.vdm.io" target="_blank">https://www.vdm.io</a> today!</p>';
	}

	/**
	 * Called on update
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update(ComponentAdapter $parent){}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $type  Which action is happening (install|uninstall|discover_install|update)
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($type, ComponentAdapter $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// is redundant or so it seems ...hmmm let me know if it works again
		if ($type === 'uninstall')
		{
			return true;
		}
		// the default for both install and update
		$jversion = new JVersion();
		if (!$jversion->isCompatible('3.8.0'))
		{
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.8.0 before continuing!', 'error');
			return false;
		}
		// do any updates needed
		if ($type === 'update')
		{
		}
		// do any install needed
		if ($type === 'install')
		{
		}
		// check if the PHPExcel stuff is still around
		if (File::exists(JPATH_ADMINISTRATOR . '/components/com_hello_world/helpers/PHPExcel.php'))
		{
			// We need to remove this old PHPExcel folder
			$this->removeFolder(JPATH_ADMINISTRATOR . '/components/com_hello_world/helpers/PHPExcel');
			// We need to remove this old PHPExcel file
			File::delete(JPATH_ADMINISTRATOR . '/components/com_hello_world/helpers/PHPExcel.php');
		}
		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $type  Which action is happening (install|uninstall|discover_install|update)
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, ComponentAdapter $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// We check if we have dynamic folders to copy
		$this->setDynamicF0ld3rs($app, $parent);
		// set the default component settings
		if ($type === 'install')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the greeting content type object.
			$greeting = new stdClass();
			$greeting->type_title = 'Hello_world Greeting';
			$greeting->type_alias = 'com_hello_world.greeting';
			$greeting->table = '{"special": {"dbtable": "#__hello_world_greeting","key": "id","type": "Greeting","prefix": "hello_worldTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$greeting->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "greeting","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"greeting":"greeting"}}';
			$greeting->router = 'Hello_worldHelperRoute::getGreetingRoute';
			$greeting->content_history_options = '{"formFile": "administrator/components/com_hello_world/models/forms/greeting.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$greeting_Inserted = $db->insertObject('#__content_types', $greeting);


			// Install the global extenstion assets permission.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('rules') . ' = ' . $db->quote('{"site.greet.access":{"1":1},"site.greetings.access":{"1":1}}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('name') . ' = ' . $db->quote('com_hello_world')
			);
			$query->update($db->quoteName('#__assets'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			// Install the global extension params.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('params') . ' = ' . $db->quote('{"autorName":"Llewellyn","autorEmail":"joomla@vdm.io","check_in":"-1 day","save_history":"1","history_limit":"10","uikit_load":"1","uikit_min":"","uikit_style":""}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('element') . ' = ' . $db->quote('com_hello_world')
			);
			$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			echo '<a target="_blank" href="https://www.vdm.io" title="Hello World">
				<img src="components/com_hello_world/assets/images/vdm-component.jpg"/>
				</a>';

			// Set db if not set already.
			if (!isset($db))
			{
				$db = JFactory::getDbo();
			}
			// Create the hello_world action logs extensions object.
			$hello_world_action_logs_extensions = new stdClass();
			$hello_world_action_logs_extensions->extension = 'com_hello_world';

			// Set the object into the action logs extensions table.
			$hello_world_action_logs_extensions_Inserted = $db->insertObject('#__action_logs_extensions', $hello_world_action_logs_extensions);

			// Set db if not set already.
			if (!isset($db))
			{
				$db = JFactory::getDbo();
			}
			// Create the greeting action log config object.
			$greeting_action_log_config = new stdClass();
			$greeting_action_log_config->type_title = 'GREETING';
			$greeting_action_log_config->type_alias = 'com_hello_world.greeting';
			$greeting_action_log_config->id_holder = 'id';
			$greeting_action_log_config->title_holder = 'greeting';
			$greeting_action_log_config->table_name = '#__hello_world_greeting';
			$greeting_action_log_config->text_prefix = 'COM_HELLO_WORLD';

			// Set the object into the action log config table.
			$greeting_Inserted = $db->insertObject('#__action_log_config', $greeting_action_log_config);
		}
		// do any updates needed
		if ($type === 'update')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the greeting content type object.
			$greeting = new stdClass();
			$greeting->type_title = 'Hello_world Greeting';
			$greeting->type_alias = 'com_hello_world.greeting';
			$greeting->table = '{"special": {"dbtable": "#__hello_world_greeting","key": "id","type": "Greeting","prefix": "hello_worldTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$greeting->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "greeting","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"greeting":"greeting"}}';
			$greeting->router = 'Hello_worldHelperRoute::getGreetingRoute';
			$greeting->content_history_options = '{"formFile": "administrator/components/com_hello_world/models/forms/greeting.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if greeting type is already in content_type DB.
			$greeting_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($greeting->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$greeting->type_id = $db->loadResult();
				$greeting_Updated = $db->updateObject('#__content_types', $greeting, 'type_id');
			}
			else
			{
				$greeting_Inserted = $db->insertObject('#__content_types', $greeting);
			}


			echo '<a target="_blank" href="https://www.vdm.io" title="Hello World">
				<img src="components/com_hello_world/assets/images/vdm-component.jpg"/>
				</a>
				<h3>Upgrade to Version 1.1.0 Was Successful! Let us know if anything is not working as expected.</h3>';

			// Set db if not set already.
			if (!isset($db))
			{
				$db = JFactory::getDbo();
			}
			// Create the hello_world action logs extensions object.
			$hello_world_action_logs_extensions = new stdClass();
			$hello_world_action_logs_extensions->extension = 'com_hello_world';

			// Check if hello_world action log extension is already in action logs extensions DB.
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('id')));
			$query->from($db->quoteName('#__action_logs_extensions'));
			$query->where($db->quoteName('extension') . ' LIKE '. $db->quote($hello_world_action_logs_extensions->extension));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the action logs extensions table if not found.
			if (!$db->getNumRows())
			{
				$hello_world_action_logs_extensions_Inserted = $db->insertObject('#__action_logs_extensions', $hello_world_action_logs_extensions);
			}

			// Set db if not set already.
			if (!isset($db))
			{
				$db = JFactory::getDbo();
			}
			// Create the greeting action log config object.
			$greeting_action_log_config = new stdClass();
			$greeting_action_log_config->id = null;
			$greeting_action_log_config->type_title = 'GREETING';
			$greeting_action_log_config->type_alias = 'com_hello_world.greeting';
			$greeting_action_log_config->id_holder = 'id';
			$greeting_action_log_config->title_holder = 'greeting';
			$greeting_action_log_config->table_name = '#__hello_world_greeting';
			$greeting_action_log_config->text_prefix = 'COM_HELLO_WORLD';

			// Check if greeting action log config is already in action_log_config DB.
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('id')));
			$query->from($db->quoteName('#__action_log_config'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($greeting_action_log_config->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$greeting_action_log_config->id = $db->loadResult();
				$greeting_action_log_config_Updated = $db->updateObject('#__action_log_config', $greeting_action_log_config, 'id');
			}
			else
			{
				$greeting_action_log_config_Inserted = $db->insertObject('#__action_log_config', $greeting_action_log_config);
			}
		}
		return true;
	}

	/**
	 * Remove folders with files
	 * 
	 * @param   string   $dir     The path to folder to remove
	 * @param   boolean  $ignore  The folders and files to ignore and not remove
	 *
	 * @return  boolean   True in all is removed
	 * 
	 */
	protected function removeFolder($dir, $ignore = false)
	{
		if (Folder::exists($dir))
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			// remove ending /
			$dir = rtrim($dir, '/');
			// now loop the files & folders
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
				// set file dir
				$file_dir = $file->getPathname();
				// check if this is a dir or a file
				if ($file->isDir())
				{
					$keeper = false;
					if ($this->checkArray($ignore))
					{
						foreach ($ignore as $keep)
						{
							if (strpos($file_dir, $dir.'/'.$keep) !== false)
							{
								$keeper = true;
							}
						}
					}
					if ($keeper)
					{
						continue;
					}
					Folder::delete($file_dir);
				}
				else
				{
					$keeper = false;
					if ($this->checkArray($ignore))
					{
						foreach ($ignore as $keep)
						{
							if (strpos($file_dir, $dir.'/'.$keep) !== false)
							{
								$keeper = true;
							}
						}
					}
					if ($keeper)
					{
						continue;
					}
					File::delete($file_dir);
				}
			}
			// delete the root folder if not ignore found
			if (!$this->checkArray($ignore))
			{
				return Folder::delete($dir);
			}
			return true;
		}
		return false;
	}

	/**
	 * Check if have an array with a length
	 *
	 * @input	array   The array to check
	 *
	 * @returns bool/int  number of items in array on success
	 */
	protected function checkArray($array, $removeEmptyString = false)
	{
		if (isset($array) && is_array($array) && ($nr = count((array)$array)) > 0)
		{
			// also make sure the empty strings are removed
			if ($removeEmptyString)
			{
				foreach ($array as $key => $string)
				{
					if (empty($string))
					{
						unset($array[$key]);
					}
				}
				return $this->checkArray($array, false);
			}
			return $nr;
		}
		return false;
	}

	/**
	 * Method to set/copy dynamic folders into place (use with caution)
	 *
	 * @return void
	 */
	protected function setDynamicF0ld3rs($app, $parent)
	{
		// get the instalation path
		$installer = $parent->getParent();
		$installPath = $installer->getPath('source');
		// get all the folders
		$folders = Folder::folders($installPath);
		// check if we have folders we may want to copy
		$doNotCopy = array('media','admin','site'); // Joomla already deals with these
		if (count((array) $folders) > 1)
		{
			foreach ($folders as $folder)
			{
				// Only copy if not a standard folders
				if (!in_array($folder, $doNotCopy))
				{
					// set the source path
					$src = $installPath.'/'.$folder;
					// set the destination path
					$dest = JPATH_ROOT.'/'.$folder;
					// now try to copy the folder
					if (!Folder::copy($src, $dest, '', true))
					{
						$app->enqueueMessage('Could not copy '.$folder.' folder into place, please make sure destination is writable!', 'error');
					}
				}
			}
		}
	}
}
