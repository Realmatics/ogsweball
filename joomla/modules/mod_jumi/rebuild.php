<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.database.tablenested');
    $db =& JFactory::getDBO();
    $menu = new JTableNested('#__menu', 'id',&$db);
    return $menu->rebuild();
	

?>