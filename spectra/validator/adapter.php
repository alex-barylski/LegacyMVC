<?php

  define('OPTIONAL', 0);
  define('REQUIRED', 1);

  final class Spectra_Validator_Adapter{

    const REQUIRED_FIELD_DEFAULT_ERROR = '{:label:} is a required field and cannot be empty.';

    private $messages = array();
    private $provider = null;

    public function __construct($validator, $required, $label = '', $error = self::REQUIRED_FIELD_DEFAULT_ERROR)
    {
      if(!is_subclass_of($validator, 'Spectra_Validator_Provider_Abstract')){
        trigger_error('Validator provider '.get_class($validator).' is not an object of type Spectra_Validator_Provider_Abstract.');
      }

      $value = $validator->getValue();
      if(empty($value) && $required){
        $placeholders = array
        (
          '{:label:}' => $label,
        );

        $this->messages[] = _T($error, $placeholders);
      }

      $this->provider = $validator->setLabel($label);
    }

    public function getProvider()
    {
      return $this->provider;
    }

    public function getMessages()
    {
      return array_merge($this->messages, $this->getProvider()->getMessages());
    }

    public function isValid()
    {
      if(count($this->getMessages()) > 0){
        return false;
      }

      return true;
    }

  }

  //
  // NOTE: Declare a simple method to process placeholders in error messages
  //

  if(!function_exists('_T')){
    function _T($text, $params = null)
    {
      if(is_array($params)){
        $text = str_replace(array_keys($params), array_values($params), $text);
      }

      return $text;
    }
  }
