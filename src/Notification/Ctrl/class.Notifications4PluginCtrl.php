<?php

namespace srag\Plugins\SrAutoMails\Notification\Ctrl;

use ilSrAutoMailsConfigGUI;
use ilSrAutoMailsPlugin;
use ilUtil;
use srag\Notifications4Plugin\SrAutoMails\Ctrl\AbstractCtrl;
use srag\Plugins\SrAutoMails\Notification\Notification\Language\NotificationLanguage;
use srag\Plugins\SrAutoMails\Notification\Notification\Notification;
use srag\Plugins\SrAutoMails\Utils\SrAutoMailsTrait;

/**
 * Class Notifications4PluginCtrl
 *
 * @package           srag\Plugins\SrAutoMails\Notification\Ctrl
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy srag\Plugins\SrAutoMails\Notification\Ctrl\Notifications4PluginCtrl: ilSrAutoMailsConfigGUI
 */
class Notifications4PluginCtrl extends AbstractCtrl {

	use SrAutoMailsTrait;
	const NOTIFICATION_CLASS_NAME = Notification::class;
	const LANGUAGE_CLASS_NAME = NotificationLanguage::class;
	const PLUGIN_CLASS_NAME = ilSrAutoMailsPlugin::class;


	/**
	 * @inheritdoc
	 */
	public function executeCommand()/*: void*/ {
		$rule_id = intval(filter_input(INPUT_GET, ilSrAutoMailsConfigGUI::GET_PARAM_RULE_ID));
		$rule = self::rules()->getRuleById($rule_id);
		(new ilSrAutoMailsConfigGUI())->getRuleForm($rule);

		self::dic()->tabs()->activateSubTab(ilSrAutoMailsConfigGUI::TAB_NOTIFICATION);

		if ($rule !== null) {

			$object_type_definiton = self::objectTypes()->factory()->getByObjectType($rule->getObjectType());

			if ($object_type_definiton !== null) {
				ilUtil::sendInfo(current(self::notificationUI()->withPlugin(self::plugin())
					->templateSelection([], "", $object_type_definiton->getMailPlaceholderKeyTypes()))["setInfo"]);
			}
		}

		parent::executeCommand();
	}


	/**
	 * @inheritdoc
	 */
	protected function listNotifications()/*: void*/ {
		self::dic()->ctrl()->redirectByClass(ilSrAutoMailsConfigGUI::class, ilSrAutoMailsConfigGUI::CMD_EDIT_RULE);
	}
}
