<?php

abstract class Pushpress_ApiResource extends Pushpress_Object
{
  protected static function _scopedRetrieve($class, $id=null, $apiKey=null, $params=array())
  {      

    if (is_null($id) ||  (! strlen(trim($id))) )  { 
      throw new Pushpress_Error("You must pass an value Identifer into the retrieve function to get an object.");
    }
    $instance = new $class($id, $apiKey);
    $instance->refresh($params);
    return $instance;
  }
  
  public function refresh($params=array())
  {      
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl();
    
    if (count($params)) {
        $url .= "?";
        foreach ($params as $key=>$value) {
            $url .= $key . "=" . $value . "&";
        }
    }

    list($response, $apiKey) = $requestor->request('get', $url, $this->_retrieveOptions);
    $this->refreshFrom($response, $apiKey);
    
    return $this;
   }
  
  protected static function _scopedRetrieveEmpty($class, $apiKey=null)
  {
    $instance = new $class($apiKey);
    $instance->refreshEmpty();
    return $instance;
  }
  
  protected static function _scopedActive($class, $apiKey=null)
  {
    $instance = new $class($apiKey);
    $instance->refreshActive();
    return $instance;
  }
  
  protected static function _scopedInactive($class, $apiKey=null)
  {
    $instance = new $class($apiKey);
    $instance->refreshInactive();
    return $instance;
  }
  
  public function refreshEmpty()
  {
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->emptyUrl();
    // echo $url;
    // die();
    list($response, $apiKey) = $requestor->request('get', $url, $this->_retrieveOptions);
    $this->refreshFrom($response, $apiKey);
    return $this;
   }
  
  public function refreshActive()
  {
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->activeUrl();
    list($response, $apiKey) = $requestor->request('get', $url, $this->_retrieveOptions);
    $this->refreshFrom($response, $apiKey);
    return $this;
   }
  
  public function refreshInactive()
  {
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->inactiveUrl();

    list($response, $apiKey) = $requestor->request('get', $url, $this->_retrieveOptions);
    $this->refreshFrom($response, $apiKey);
    return $this;
   }
  

  public static function className($class)
  {
    // Useful for namespaces: Foo\Pushpress_Charge
    if ($postfix = strrchr($class, '\\'))
      $class = substr($postfix, 1);
    if (substr($class, 0, strlen('Pushpress')) == 'Pushpress')
      $class = substr($class, strlen('Pushpress'));
    $class = str_replace('_', '', $class);
    $name = urlencode($class);
    $name = strtolower($name);
    return $name;
  }

  public static function classUrl($class)
  {
    $base = self::_scopedLsb($class, 'className', $class);
    return "/v1/${base}s";
  }

    public function instanceUrl()
    {
        $id = $this['id'];    
        $class = get_class($this);
    $id = Pushpress_ApiRequestor::utf8($id);
    $base = $this->_lsb('classUrl', $class);
    $base = preg_replace("/(ss)$/", "s", $base);
    $extn = urlencode($id);
    return "$base/$extn";
  }
  
  public function emptyUrl()
  {      
    $class = get_class($this);
    $base = $this->_lsb('classUrl', $class);
    // fix double plural
    $base = preg_replace("/(ss)$/", "s", $base);
    $extn = urlencode('empty');
    return "$base/$extn";
  }
  
  public function activeUrl()
  {      
    $class = get_class($this);
    $base = $this->_lsb('classUrl', $class);
    $base = preg_replace("/(ss)$/", "s", $base);  
    $extn = urlencode('active');
    
    return "$base/$extn";
  }
  
  public function inactiveUrl()
  {      
    $class = get_class($this);
    $base = $this->_lsb('classUrl', $class);
    $base = preg_replace("/(ss)$/", "s", $base);
    $extn = urlencode('active');
    return "$base/$extn";
  }

  private static function _validateCall($method, $params=null, $apiKey=null)
  {
    if ($params && !is_array($params))
      throw new Pushpress_Error("You must pass an array as the first argument to Pushpress API method calls.  (HINT: an example call to create a charge would be: \"PushpressCharge::create(array('amount' => 100, 'currency' => 'usd', 'card' => array('number' => 4242424242424242, 'exp_month' => 5, 'exp_year' => 2015)))\")");
    if ($apiKey && !is_string($apiKey))
      throw new Pushpress_Error('The second argument to Pushpress API method calls is an optional per-request apiKey, which must be a string.  (HINT: you can set a global apiKey by "PushpressApi::setApiKey(<apiKey>)")');
  }

  protected static function _scopedAll($class, $params=null, $apiKey=null)
  {
    
    self::_validateCall('all', $params, $apiKey);
    $requestor = new Pushpress_ApiRequestor($apiKey);
    
    
    $url = self::_scopedLsb($class, 'classUrl', $class);
    $url = preg_replace("/(ss)$/", "s", $url);
    
    list($response, $apiKey) = $requestor->request('get', $url, $params);
    return Pushpress_Util::convertToPushpressObject($response, $apiKey);
  }

  protected static function _scopedCreate($class, $params=null, $apiKey=null)
  {
    self::_validateCall('create', $params, $apiKey);
    $requestor = new Pushpress_ApiRequestor($apiKey);
    $url = self::_scopedLsb($class, 'classUrl', $class);
    $url = preg_replace("/(ss)$/", "s", $url);
    // echo $url;
//      echo '<br>';
  //    var_dump($params);
    //die();
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    return Pushpress_Util::convertToPushpressObject($response, $apiKey);
  }

  protected function _scopedSave($class)
  {
    self::_validateCall('save');
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $params = $this->serializeParameters();
    
    if (count($params) > 0) {
      $url = $this->instanceUrl();
      // echo "<br>URL: " . $url;
      // echo "<br>params:<br>";
      // var_dump($params);
      // die();

      list($response, $apiKey) = $requestor->request('post', $url, $params);
      $this->refreshFrom($response, $apiKey);
    }
    return $this;
  }

  protected function _scopedUpdate($class)
  {
    self::_validateCall('save');
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $params = $this->serializeParameters();
    // echo 'PRARAMS:<br>';var_dump($params);
    // die();
    if (count($params) > 0) {
      $url = $this->instanceUrl();
      list($response, $apiKey) = $requestor->request('put', $url, $params);
      $this->refreshFrom($response, $apiKey);
    }
    return $this;
  }

  protected function _scopedDelete($class, $params=null)
  {
    self::_validateCall('delete');
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl();
    
    list($response, $apiKey) = $requestor->request('delete', $url, $params);
    $this->refreshFrom($response, $apiKey);
    return $this;
  }
}
