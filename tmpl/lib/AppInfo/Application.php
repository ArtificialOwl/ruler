<?php

namespace OCA\{{app_namespace}}\AppInfo;

use OCA\{{app_namespace}}\Controller\SimpleController;
use OCA\{{app_namespace}}\Controller\NavigationController;
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

		$container = $this->getContainer();

		$this->registerCore($container);
		$this->registerServices($container);
		$this->registerControllers($container);
	}


	/**
	 * @param IAppContainer $container
	 */
	public function registerServices(IAppContainer $container) {

		$container->registerService(
			'MiscService', function(IAppContainer $c) {
			return new MiscService($c->query('Logger'));
		}
		);

		$container->registerService(
			'ConfigService', function(IAppContainer $c) {
			return new ConfigService(
				$c->query('CoreConfig'), $c->query('UserId'), $c->query('MiscService')
			);
		}
		);

		$container->registerService(
			'SimpleService', function(IAppContainer $c) {
			return new SimpleService($c->query('MiscService'));
		}
		);
	}


	/**
	 * @param IAppContainer $container
	 */
	public function registerControllers(IAppContainer $container) {

		$container->registerService(
			'NavigationController', function(IAppContainer $c) {
			return new NavigationController(self::APP_NAME, $c->query('Request'), $c->query('UserId'));
		}
		);

		$container->registerService(
			'SimpleController', function(IAppContainer $c) {
			return new SimpleController(self::APP_NAME, $c->query('Request'));
		}
		);
	}


	/**
	 * @param IAppContainer $container
	 */
	public function registerCore(IAppContainer $container) {

		$container->registerService(
			'Logger', function(IAppContainer $c) {
			return $c->query('ServerContainer')
					 ->getLogger();
		}
		);

		$container->registerService(
			'L10N', function(IAppContainer $c) {
			return $c->query('ServerContainer')
					 ->getL10N(self::APP_NAME);
		}
		);

		$container->registerService(
			'CoreConfig', function(IAppContainer $c) {
			return $c->query('ServerContainer')
					 ->getConfig();
		}
		);

		$container->registerService(
			'UserId', function(IAppContainer $c) {
			/** @var IUser $user */
			$user = $c->query('ServerContainer')
					  ->getUserSession()
					  ->getUser();

			return is_null($user) ? '' : $user->getUID();
		}
		);
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
						 'icon' => $urlGen->imagePath(self::APP_NAME, 'app.svg'),
						 'name' => $navName
					 ];
				 }
			 );
	}

	public function registerSettingsAdmin() {
		\OCP\App::registerAdmin(
			self::APP_NAME, 'templates/settings.admin'
		);
	}

	public function registerSettingsPersonal() {
		\OCP\App::registerPersonal(
			self::APP_NAME, 'templates/settings.personal'
		);
	}


}

