<?php

  abstract class Spectra_Application_Controller_Command{

    protected function getFrontObject()
    {
      return Spectra_Application_Controller_Front::getInstance();
    }

    protected function getRequestObject()
    {
      return $this->getFrontObject()->getRequestObject();
    }

    protected function getResponseObject()
    {
      return $this->getFrontObject()->getResponseObject();
    }

  }