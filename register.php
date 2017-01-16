<?php

$GLOBALS['APPLICATION']['ACTIONS'] = [
	'showCustomerId' => null
];

$GLOBALS['APPLICATION']['ROUTES'] = [
	'/customer/id' => ['MyController', 'showCustomerId']
];
