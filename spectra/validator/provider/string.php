<?php

  class Spectra_Validator_Provider_String extends Spectra_Validator_Provider_Abstract{

    const MIN_LENGTH_DEFAULT_ERROR = '{:label:} must be at least {:min:} characters in length.';
    const MAX_LENGTH_DEFAULT_ERROR = '{:label:} must be no more than {:max:} characters in length.';

    public function minLength($length, $error = self::MIN_LENGTH_DEFAULT_ERROR)
    {
      $value = $this->getValue();

      if(!empty($value)){
        if(strlen($value) < $length){
          $array = array
          (
            '{:label:}' => $this->getLabel(),
            '{:min:}' => $length
          );

          $this->addMessage(_T($error, $array));
        }
      }

      return $this;
    }

    public function maxLength($length, $error = self::MAX_LENGTH_DEFAULT_ERROR)
    {
      $value = $this->getValue();

      if(!empty($value)){
        if(strlen($value) > $length){
          $array = array
          (
            '{:label:}' => $this->getLabel(),
            '{:max:}' => $length
          );

          $this->addMessage(_T($error, $array));
        }
      }

      return $this;
    }

  }