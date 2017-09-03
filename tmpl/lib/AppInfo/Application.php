<?php

namespace OCA\{{app_namespace}}\AppInfo;

use OCA\{{app_namespace}}\Controller\SimpleController;
use OCA\{{app_namespace}}\Controller\NavigationController;
use OCA\{{app_namespace}}\Controller\SettingsController;
use OCA\{{app_namespace}}\Service\MiscService;
use OCA\{{app_namespace}}\Service\SimpleService;
use OCA\{{app_namespace}}\Service\ConfigService;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCP\IUser;

class Application extends App {

	const APP_NAME = '{{app_id}}';

	/**
	 * @param array $params
	 */
	public function __construct(array $params = array()) {
		parent::__construct(self::APP_NAME, $params);

		$this->registerHooks();
	}


	/**
	 * Register Hooks
	 */
	public function registerHooks() {
	}



	/**
	 * Register Navigation Tab
	 */
	public function registerNavigation() {

		$this->getContainer()
			 ->getServer()
			 ->getNavigationManager()
			 ->add(
				 function() {
					 $urlGen = \OC::$server->getURLGenerator();
					 $navName = \OC::$server->getL10N(self::APP_NAME)
											->t('{{app_name}}');

					 return [
						 'id' => self::APP_NAME,
						 'order' => 5,
						 'href' => $urlGen->linkToRoute('{{app_id}}.Navigation.navigate'),
						 'icon' => $urlGen->imagePath(self::APP_NAME, 'ruler.svg'),
						 'name' => $navName
					 ];
				 }
			 );
	}


	public function registerSettingsAdmin() {
		\OCP\App::registerAdmin(self::APP_NAME, 'lib/admin');
	}

	public function registerSettingsPersonal() {
		\OCP\App::registerPersonal(self::APP_NAME, 'lib/personal');
	}
}

