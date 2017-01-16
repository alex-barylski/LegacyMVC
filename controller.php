<?php

class MyController extends Spectra_Application_Controller_Action {

	public function showCustomerId ()
	{
		$request = $this->getRequestObject();
		$response = $this->getResponseObject();

		$id = $request->getValue('id', 0);

		$response->setHeader('Content-Type', 'application/json');
		$response->setContent(json_encode($id));
	}

}
