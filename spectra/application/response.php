<?php

  class Spectra_Application_Response{

    private $content = null;

    public function getContent()
    {
      return $this->content;
    }

    public function setContent($content)
    {
      $this->content = $content;
      return $this;
    }

  }