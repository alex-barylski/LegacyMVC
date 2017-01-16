<?php

  include '../../../private/common/settings.php';  
  include '../../../private/common/functions.php';

  include '../../../../vendor/autoload.php';

  include 'register.php';

  //session_id(md5('CADORATH-2070'));
  session_start();
  //session_regenerate_id();

  date_default_timezone_set(CADORATH_SYSTEM_SETTING_TIMEZONE);  

  try{
    $response = new Spectra_Application_Environment_Http_Response();
    $request = new Spectra_Application_Environment_Http_Request();

    $router = new Spectra_Application_Controller_Router_Adapter
    (
      $_SERVER['PATH_INFO'],
      $request,
      new Common_Controller_Router($GLOBALS['AQUARIUS']['ROUTES'], key($GLOBALS['AQUARIUS']['ROUTES']))
    );

    $front = Spectra_Application_Controller_Front::getInstance();
    $front->setResponseObject($response)->setRequestObject($request);

    $front->addPrePluginFilter(new Common_Controller_Filter_ActionCheck());
    
    echo cadorath_main($router, $front)->sendResponse();
  }
  catch(Exception $e){
    $result['success'] = false;
    $result['errors']['reason'] = $e->getMessage();

    header('Content-Type: application/json');
    echo json_encode($result);
  }