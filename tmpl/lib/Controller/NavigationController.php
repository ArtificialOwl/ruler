<?php

namespace OCA\{{app_namespace}}\Controller;

use OCA\{{app_namespace}}\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;

class NavigationController extends Controller {

	/** @var string */
	private $userId;

	/**
	 * NavigationController constructor.
	 *
	 * @param string $appName
	 * @param \OCP\IRequest $request
	 * @param string $userId
	 */
	function __construct($appName, \OCP\IRequest $request, $userId) {
		parent::__construct($appName, $request);
		$this->userId = $userId;
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * @NoSubAdminRequired
	 *
	 * @return TemplateResponse
	 */
	public function navigate() {
		$data = [
			'param' => 'value'
		];

		return new TemplateResponse(
			Application::APP_NAME, 'navigate', $data
		);
	}


	/**
	 * @NoAdminRequired
	 * @NoSubAdminRequired
	 *
	 * @return DataResponse
	 */
	public function settings() {
		$data = [
			'user_id' => $this->userId,
			'status'  => 1
		];

		return new DataResponse(
			$data,
			Http::STATUS_OK
		);
	}

}


