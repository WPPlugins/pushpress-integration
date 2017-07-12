<?php

class Pushpress_Order extends Pushpress_ApiResource
{
  public static function constructFrom($values, $apiKey=null)
  {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiKey);
  }
  
  public static function active($apiKey=null)
  {
    $class = get_class();
    return self::_scopedActive($class, $apiKey);
  }

  public static function retrieve($id=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedRetrieve($class, $id, $apiKey);
  }

  public static function retrieveEmpty($id=null, $apiKey=null)
  {      
    $class = get_class();
    return self::_scopedRetrieveEmpty($class, $id, $apiKey);
  }
    
  public static function create($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedCreate($class, $params, $apiKey);
  }

  public function delete($params=null)
  {
    $class = get_class();
    return self::_scopedDelete($class, $params);
  }
  
  public function save()
  {
    $class = get_class();
    return self::_scopedSave($class);
  }
  
  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedAll($class, $params, $apiKey);
  }
  
  public function refund($params=null)
  {
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl() . '/refund';
    
    
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    $this->refreshFrom($response, $apiKey);
    return $this;
  }
  
  public function receipt($params=null)
  {
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl() . '/receipt';    
    
    list($response, $apiKey) = $requestor->request('get', $url, $params);
    $this->refreshFrom($response, $apiKey);
    return $this;
  }
  
}
