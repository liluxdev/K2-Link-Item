<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

//Based on K2 Header Element, Thanks to JoomlaWorks

class JElementLIHeader extends JElement {
	var	$_name = 'liheader';

	function fetchElement($name, $value, &$node, $control_name) {
		
		$html = '<div style="font-weight:bold;font-size:12px;color:#666;padding:4px;margin:0;background:#ccc;border:1px solid #bbb;">'.JText::_($value).'</div>';
		return $html;
	}

	function fetchTooltip($label, $description, &$node, $control_name, $name) {
		
		$html = '&nbsp;';
		return $html;
	}

}