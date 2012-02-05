<?php

/*------------------------------------------------------------------------

# plg_linkitem - Link item plugin for K2

# ------------------------------------------------------------------------

# author    Jiliko.net

# copyright Copyright (C) 2011 Jiliko.net. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.jiliko.net

# Technical Support:  Forum - http://www.jiliko.net/forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

JLoader::register('K2Plugin',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2plugin.php');

class plgK2LinkItem extends K2Plugin {

	// Some params
	var $pluginName = 'linkitem';
	var $pluginNameHumanReadable = 'K2 Link item';

	function plgK2LinkItem(&$subject, $params) {
		parent::__construct($subject, $params);
	}

	function onK2BeforeDisplay( & $item, & $params, $limitstart) {
		global $mainframe;
		
		return '';
	}
	
	function onK2AfterDisplay( & $item, & $params, $limitstart) {
		global $mainframe;

		jimport('joomla.filesystem.file');
		
		$view = JRequest::getCmd('view');
		$user = & JFactory::getUser();
		$aid = $user->get('aid');
		
		$db = & JFactory::getDBO();
		$jnow = &JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
		
		$html = '';

		if( $view == 'item' || $view == 'itemlist') {
			$plugin = & JPluginHelper::getPlugin('k2', 'linkitem');
			$pluginParams = new JParameter($plugin->params);
	
			$pluginItemParams = $objectParams = $this->k2TOJParameter($item->plugins, $this->pluginName);
			$pluginParams->merge($pluginItemParams);
			
			$showLinkedItem = ($view == 'itemlist') ? $pluginParams->get('catLinkedItem',0) : $pluginParams->get('linkedItem',0);
			$tmplFile = ($view == 'itemlist') ? 'category' : 'item';
			
			$value = $pluginParams->get('items');
			
			$current = array();
			
			if(is_string($value) && !empty($value))
				$current[]=$value;
			
			if(is_array($value))
				$current=$value;

			$linkItems = array();

			foreach($current as $id){

				$query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";
				$query .= " FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";
				$query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";
				$query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
				$query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";
				$query .= " AND i.id={$id}";
				
				$db->setQuery($query);
				$linkedItem = $db->loadObject();
				if($linkedItem)
				$linkedItems[]=$linkedItem;
			}
			
			if (count($linkedItems) && $showLinkedItem) {
				
				foreach($linkedItems as & $linkedItem) {

					switch ($view) {
						case 'itemlist':
							if($pluginParams->get('catLinkedItemImage',0)) {
								if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$linkedItem->id).'_'.$pluginParams->get('catLinkedItemImageSize').'.jpg'))
									$linkedItem->image = JURI::root().'media/k2/items/cache/'.md5("Image".$linkedItem->id).'_'.$pluginParams->get('catLinkedItemImageSize').'.jpg';
							}
							
							if ($pluginParams->get('catLinkedItemIntroTextWordLimit')) {
								$linkedItem->introtext = K2HelperUtilities::wordLimit($linkedItem->introtext, $pluginParams->get('catLinkedItemIntroTextWordLimit'));
							}
						break;
						case 'item':
							if($pluginParams->get('linkedItemImage',0)) {
								if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$linkedItem->id).'_'.$pluginParams->get('linkedItemImageSize').'.jpg'))
									$linkedItem->image = JURI::root().'media/k2/items/cache/'.md5("Image".$linkedItem->id).'_'.$pluginParams->get('linkedItemImageSize').'.jpg';
							}

							if ($pluginParams->get('linkedItemIntroTextWordLimit')) {
								$linkedItem->introtext = K2HelperUtilities::wordLimit($linkedItem->introtext, $pluginParams->get('linkedItemIntroTextWordLimit'));
							}
						break;
					}
							
					//Read more link
					$linkedItem->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($linkedItem->id.':'.urlencode($linkedItem->alias), $linkedItem->catid.':'.urlencode($linkedItem->categoryalias))));
							
					//Clean the plugin tags
					$linkedItem->introtext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $linkedItem->introtext);
				}
				
				unset($linkedItem);
				
				//Load css file
				$document = &JFactory::getDocument();
			
				if($pluginParams->get('loadPluginCss',1) && JFile::exists(dirname(__FILE__).DS.'linkitem'.DS.'linkitem.css'))
					$document->addStyleSheet(JURI::root().'plugins/k2/linkitem/linkitem.css');
								
				if (JFile::exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'plg_k2_linkitem'.DS.$tmplFile.'.php'))
					$defaultFile = JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'plg_k2_linkitem'.DS.$tmplFile.'.php';
				else
					$defaultFile = dirname(__FILE__).DS.'linkitem'.DS.$tmplFile.'.php';
				
				ob_start();
				include($defaultFile);
				$output = ob_get_contents();
				ob_end_clean();
				$html = $output;
			}
		}

		return $html;
	}

	function onK2AfterDisplayTitle( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}

	function onK2BeforeDisplayContent( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}

	function onK2AfterDisplayContent( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}
	
	function onK2CategoryDisplay( & $category, & $params, $limitstart) {
		global $mainframe;
		
		return '';
	}

	function onK2UserDisplay( & $user, & $params, $limitstart) {

		global $mainframe;
		
		return '';
	}
	
	function k2TOJParameter($k2Plugins,$k2Plugin) {

		$k2Registry = new JRegistry();
		$k2Registry->loadINI($k2Plugins);
		$k2Array['plugins'] = $k2Registry->toArray();

		$jArray = array();

		foreach($k2Array['plugins'] as $k2Param => $k2Value) {
			$jArray[str_replace($k2Plugin,"",$k2Param)] = $k2Value;
		}
		$jRegistry = new JRegistry('_default');
		$jRegistry->loadArray($jArray);

		return $jRegistry;
	}
	
	function onRenderAdminForm (& $element, $type, $tab='') {

		$mainframe = &JFactory::getApplication();
		
		if (!($mainframe->isAdmin())) {
			return null;
		}
		
		return parent::onRenderAdminForm ($element, $type, $tab);
	}
} // END CLASS
