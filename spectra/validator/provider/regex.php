<?php

  class Spectra_Validator_Provider_Regex extends Spectra_Validator_Provider_String{

    const INVALID_FORMAT_DEFAULT_ERROR = '{:label:} is invalid ({:value:}). Please use the following as an example ({:example:}) and try again.';

    private $pattern = '';

    public function __construct($value, $pattern)
    {
      $this->pattern = $pattern;
      parent::__construct($value);
    }

    public function verifyFormat($example, $error = self::INVALID_FORMAT_DEFAULT_ERROR)
    {
      $value = $this->getValue();

      if(!empty($value)){
        if(preg_match($this->pattern, $value) == 0){

          $array = array
          (
            '{:label:}' => $this->getLabel(),
            '{:value:}' => $value,
            '{:example:}' => $example
          );

          $this->addMessage(_T($error, $array));
        }
      }
    }

  }