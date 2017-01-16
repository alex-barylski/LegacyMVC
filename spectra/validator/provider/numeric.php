<?php

  class Spectra_Validator_Provider_Numeric extends Spectra_Validator_Provider_Abstract{

    const MIN_RANGE_DEFAULT_ERROR = '{:label:} must be no less than {:min:}.';
    const MAX_RANGE_DEFAULT_ERROR = '{:label:} must be no greater than {:max:}.';

    public function minRange($range, $error = self::MIN_RANGE_DEFAULT_ERROR)
    {
      $value = $this->getValue();

      //if(!empty($value)){
        if($value < $range){
          $array = array
          (
            '{:label:}' => $this->getLabel(),
            '{:min:}' => $range
          );

          $this->addMessage(_T($error, $array));
        }
      //}

      return $this;
    }

    public function maxRange($range, $error = self::MAX_RANGE_DEFAULT_ERROR)
    {
      $value = $this->getValue();

      //if(!empty($value)){
        if($value > $range){
          $array = array
          (
            '{:label:}' => $this->getLabel(),
            '{:max:}' => $range
          );

          $this->addMessage(_T($error, $array));
        }
      //}

      return $this;
    }

  }