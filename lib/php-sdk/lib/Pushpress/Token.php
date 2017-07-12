<?php

class Pushpress_Token extends Pushpress_ApiResource
{
    
  public static function constructFrom($values, $apiKey=null)
  {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiKey);
  }

  public static function retrieve($id, $params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedRetrieve($class, $id, $apiKey, $params);
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

  public function update() { 
      $class = get_class();
      return self::_scopedUpdate($class);
  }
  
  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedAll($class, $params, $apiKey);
  }

  public function pair($params) { 
    $class = get_class();
    $url = self::classUrl($class);
    $url .= "/pair";
    $requestor = new Pushpress_ApiRequestor(); 
      
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    return self::scopedConstructFrom($class, $response, $apiKey);    
  }
}

