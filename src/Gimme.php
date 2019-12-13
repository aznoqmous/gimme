<?php

namespace Aznoqmous;

/*
* File download utility
* Save file locally
*/
class Gimme
{
  public $options = [
    'dir' => 'public'
  ];

  public function __construct($options = [])
  {
    $this->options = array_merge($this->options, $options);
    foreach($this->options as $key => $value) {
      $this->{$key} = $value;
    }
    $this->relativePath = $this->dir;
    $this->dir = getcwd() . '/' . $this->dir;
    $this->dir = str_replace('\\', '/', $this->dir);
  }

  public function save($url, $overwrite=false, $path=false)
  {
    if(!$url) return false;
    $path = ($path)?: $this->getPath($url);
    $localPath = $this->dir . $path;
    $relativePath = $this->relativePath . $path;

    $dirPath = preg_replace('/\/[^\/]*?$/s', '', $localPath);

    if(!is_dir($dirPath)) {
      mkdir($dirPath, 0777, TRUE);
    }

    if(!$overwrite && file_exists($localPath)) return "$relativePath"; // already downloaded

    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($localPath)){
        unlink($localPath);
    }
    $fp = fopen($localPath,'x');
    fwrite($fp, $raw);
    fclose($fp);

    return "$relativePath";
  }

  public function getPath($url)
  {
    $path = preg_replace('/^.*?\..*?\//', '/', $url); // extract path
    $path = preg_replace('/\?.*?$/', '', $path); // remove url parameters
    return $path;
  }
}
