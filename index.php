<?php

include 'register.php';
include 'boostrap.php';

session_start();

date_default_timezone_set(SYSTEM_SETTING_TIMEZONE);

try {
	$response = new Spectra_Application_Environment_Http_Response();
	$request = new Spectra_Application_Environment_Http_Request();

	$router = new Spectra_Application_Controller_Router_Adapter(
		$_SERVER['PATH_INFO'], $request, new Common_Controller_Router($GLOBALS['APPLICATION']['ROUTES'], key($GLOBALS['APPLICATION']['ROUTES']))
	);

	$front = Spectra_Application_Controller_Front::getInstance();
	$front->setResponseObject($response)->setRequestObject($request);

	// TODO: Add pre-action filters here
	//$front->addPrePluginFilter(new Common_Controller_Filter_ActionCheck());

	echo application_main($router, $front)->sendResponse();
}
catch (Exception $e) {
	$result['success'] = false;
	$result['errors']['reason'] = $e->getMessage();

	header('Content-Type: application/json');
	echo json_encode($result);
}