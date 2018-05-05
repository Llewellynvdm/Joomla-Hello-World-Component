<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				VDM 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th May, 2018
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

JHTML::_('behavior.modal');
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');

/**
 * Script File of Hello_world Component
 */
class com_hello_worldInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{

	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// Get Application object
		$app = JFactory::getApplication();

		// Get The Database object
		$db = JFactory::getDbo();

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
			if ($greeting_done);
			{
				// If succesfully remove Greeting add queued success message.
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
			if ($greeting_done);
			{
				// If succesfully remove Greeting add queued success message.
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
			if ($greeting_done);
			{
				// If succesfully remove Greeting add queued success message.
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
		if ($greeting_done);
		{
			// If succesfully remove hello_world add queued success message.
			$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));
		}

		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:joomla@vdm.io">joomla@vdm.io</a>.
		<br />We at VDM are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="https://www.vdm.io" target="_blank">https://www.vdm.io</a> today!</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// is redundant ...hmmm
		if ($type == 'uninstall')
		{
			return true;
		}
		// the default for both install and update
		$jversion = new JVersion();
		if (!$jversion->isCompatible('3.6.0'))
		{
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.6.0 before continuing!', 'error');
			return false;
		}
		// do any updates needed
		if ($type == 'update')
		{
		}
		// do any install needed
		if ($type == 'install')
		{
		}
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// set the default component settings
		if ($type == 'install')
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

			// Install the global extenstion params.
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
		}
		// do any updates needed
		if ($type == 'update')
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
				<h3>Upgrade to Version 1.0.0 Was Successful! Let us know if anything is not working as expected.</h3>';
		}
	}
}
