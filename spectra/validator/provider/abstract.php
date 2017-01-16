<?php

  abstract class Spectra_Validator_Provider_Abstract{

    private $messages = array();

    private $value = null;
    private $label = '';

    public function __construct($value)
    {
      $this->value = $value;
    }

    public function getValue()
    {
      return $this->value;
    }

    public function getLabel()
    {
      return $this->label;
    }

    public function setLabel($label)
    {
      $this->label = $label;
      return $this;
    }

    public function getMessages()
    {
      return $this->messages;
    }

    protected function addMessage($message)
    {
      $this->messages[] = $message;
      return $this;
    }

  }