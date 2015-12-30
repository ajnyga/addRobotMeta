<?php

/**
 * @file plugins/generic/addRobotMeta/AddRobotMetaPlugin.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AddRobotMetaPlugin
 * @ingroup plugins_generic_addRobotMeta
 *
 * @brief Add robot meta for hidden unpublished journals, just because
 */

import('lib.pkp.classes.plugins.GenericPlugin');


class AddRobotMetaPlugin extends GenericPlugin {
	
	function register($category, $path) {
		if (parent::register($category, $path)) {			
				HookRegistry::register('TemplateManager::display', array(&$this, 'addmeta'));
			return true;
		}
		return false;
	}

	function getName() {
		return 'AddRobotMeta';
	}

	function getDisplayName() {
		return "AddRobotMeta plugin";
	}

	function getEnabled() {
		return true;
	}
	
	function isSitePlugin() {
		return true;
	}	

	function getManagementVerbs() {
		return array();
	}		
	
	function getDescription() {
		return "Add robot meta for hidden journals to prevent unwanted indexing";
	}
	
	function addmeta($hookName, $args) {
		
		$journal =& Request::getJournal();
		
		if (isset($journal)){
		
			$isEnabled = $journal->getEnabled();
		
			if ($isEnabled == 0){
				$templateManager =& $args[0];
				$additionalHeadData = $templateManager->get_template_vars('additionalHeadData');
				$robottext = '<meta name="robots" content="noindex, nofollow">';
				$templateManager->assign('additionalHeadData', $additionalHeadData."\n\t".$robottext);
			}
		}
	}	


}
?>
