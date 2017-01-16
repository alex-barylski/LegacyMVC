<?php

function application_main ($router, $front)
{
	$controller_name = $router->getProvider()->getControllerName();
	$controller_action = $router->getProvider()->getControllerAction();

	$controller_object = new $controller_name();

	$front->dispatchAction($controller_object, $controller_action);

	return $front->getResponseObject();
}
