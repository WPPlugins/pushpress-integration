<?php
abstract class PushpressApi
{
  public static $apiKey;
  public static $apiBase = 'https://api.pushpress.com';
  public static $apiVersion = null;
  public static $verifySslCerts = false;
  const VERSION = '1.0.0';
  
  public final function __construct() {
      echo '<bR>constructing API:';
      var_dump($this);
  }

  public static function getApiKey()
  {
    return self::$apiKey;
  }

  public static function setApiKey($apiKey)
  {
    self::$apiKey = $apiKey;
  }
  
  public static function getHost()
  {
    return self::$apiBase;
  }
  
  public static function setHost($host)
  {
    self::$apiBase = $host;
  }

  public static function getApiVersion()
  {
    return self::$apiVersion;
  }

  public static function setApiVersion($apiVersion)
  {
    self::$apiVersion = $apiVersion;
  }

  public static function getVerifySslCerts() {
    return self::$verifySslCerts;
  }

  public static function setVerifySslCerts($verify) {
    self::$verifySslCerts = $verify;
  }
}
