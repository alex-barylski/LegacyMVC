<?php

  class Spectra_Helper_FileScanner{

    const INCLUDE_FILES = true;
    const EXCLUDE_FILES = false;

    public function listMatchingFiles($exclude_patterns, $include_patterns, $start_path = '.')
    {
      $files = $this->listAllFiles($start_path);

      if(!empty($exclude_patterns)){
        $files = self::processFiles($exclude_patterns, $files, self::EXCLUDE_FILES);
      }

      if(!empty($include_patterns)){
        $files = self::processFiles($include_patterns, $files, self::INCLUDE_FILES);
      }

      return $files;
    }

    protected function listAllFiles($path)
    {
      $temp = array();
      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
      foreach($files as $name){
        $temp[] = str_replace(getcwd(), '', realpath((string)$name));
      }

      return $temp;
    }

    protected function processFiles($patterns, $files, $flag)
    {
      $temp = array();

      foreach($files as $file){
        if(self::matchFileAgainstPatterns($patterns, $file) === $flag){
          $temp[] = $file;
        }
      }

      return $temp;
    }

    protected static function matchFileAgainstPatterns($patterns, $file)
    {
      foreach($patterns as $pattern){
        if(fnmatch($pattern, $file) === true){
          return true;
        }
      }

      return false;
    }

  }