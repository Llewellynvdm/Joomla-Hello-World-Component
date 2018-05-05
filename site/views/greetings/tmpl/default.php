<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				VDM 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th May, 2018
	@created		20th September, 2017
	@package		Hello World
	@subpackage		default.php
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

$edit = "index.php?option=com_hello_world&view=greetings&task=greeting.edit";

?>
<?php echo $this->toolbar->render(); ?> 
<ul class="uk-list uk-list-striped">
<?php foreach ($this->items as $item): ?>
<li><?php echo JText::_('COM_HELLO_WORLD_GREETING'); ?>: <a href="<?php echo JRoute::_(Hello_worldHelperRoute::getGreetRoute($item->slug)); ?>"><?php echo $item->greeting; ?></a> <a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo JText::_('COM_HELLO_WORLD_EDIT'); ?></a></li>
<?php endforeach; ?>
</ul> 
