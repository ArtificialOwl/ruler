<?php

namespace OCA\{{app_namespace}};

use OCA\{{app_namespace}}\Controller\NavigationController;
use OCP\AppFramework\Http\TemplateResponse;

$app = new AppInfo\Application();

/** @var TemplateResponse $response */
$response = $app->getContainer()
				->query(NavigationController::class)
				->personal();

return $response->render();


