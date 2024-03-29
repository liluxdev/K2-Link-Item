<?php
/**
 * @version		$Id: items.php 1351 2011-11-25 17:04:53Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.parameter.element');

class JElementItems extends JElement
{

	var	$_name = 'items';

	function fetchElement($name, $value, &$node, $control_name){
		
		$params = &JComponentHelper::getParams('com_k2');
		
		$document = &JFactory::getDocument();
		
		JHtml::_('behavior.framework');
			
		$backendJQueryHandling = $params->get('backendJQueryHandling','remote');
		if($backendJQueryHandling=='remote'){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js');
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
		} else {
			$document->addScript(JURI::root(true).'/media/k2/assets/js/jquery-1.7.1.min.js');
			$document->addScript(JURI::root(true).'/media/k2/assets/js/jquery-ui-1.8.16.custom.min.js');
		}
		
		$mainframe = &JFactory::getApplication();
		
		$fieldName = $control_name.'['.$name.'][]';
		$image = JURI::root(true).'/administrator/templates/'.$mainframe->getTemplate().'/images/admin/publish_x.png';

		$js = "
		var \$K2 = jQuery.noConflict();
		function jSelectItem(id, title, object) {
			
			var exists = false;
			
			\$K2('#itemsList input').each(function(){
					if(\$K2(this).val()==id){
						alert('".JText::_('K2_THE_SELECTED_ITEM_IS_ALREADY_IN_THE_LIST')."');
						exists = true;
					}
			});
			
			if (document.adminForm.id.value && document.adminForm.id.value == id){
				alert('".JText::_('PLG_K2_LINKITEM_CAN_NOT_LINK_TO_ITSELF')."');
				exists = true;
			}
			
			if(!exists){
				var container = \$K2('<li/>').appendTo(\$K2('#itemsList'));
				var img = \$K2('<img/>',{class:'remove', src:'".$image."'}).appendTo(container);
				img.click(function(){\$K2(this).parent().remove();});
				var span = \$K2('<span/>',{class:'handle'}).html(title).appendTo(container);
				var input = \$K2('<input/>',{value:id, type:'hidden', name:'".$fieldName."'}).appendTo(container);
				var div = \$K2('<div/>',{style:'clear:both;'}).appendTo(container);
				\$K2('#itemsList').sortable('refresh');
				alert('".JText::_('K2_ITEM_ADDED_IN_THE_LIST', true)."');
			}
		}
		
		\$K2(document).ready(function(){
			\$K2('#itemsList').sortable({
				containment: '#itemsList',
				items: 'li',
				handle: 'span.handle'
			});
			\$K2('body').css('overflow-y', 'scroll');
			\$K2('#itemsList .remove').click(function(){
				\$K2(this).parent().remove();
			});
		});
		";

		$document->addScriptDeclaration($js);
		$document->addStyleSheet(JURI::root(true).'/media/k2/assets/css/k2.modules.css');

		$current = array();
		if(is_string($value) && !empty($value)){
			$current[]=$value;
		}
		if(is_array($value)){
			$current=$value;
		}

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables');
		$output = '<div style="clear:both"></div><ul id="itemsList">';
		foreach($current as $id){
			$row = &JTable::getInstance('K2Item', 'Table');
			$row->load($id);
			$output .= '
			<li>
				<img class="remove" src="'.$image.'" alt="'.JText::_('K2_REMOVE_ENTRY_FROM_LIST').'" />
				<span class="handle">'.$row->title.'</span>
				<input type="hidden" value="'.$row->id.'" name="'.$fieldName.'"/>
				<span style="clear:both;"></span>
			</li>
			';
		}
		$output .= '</ul>';
		return $output;
	}
}
