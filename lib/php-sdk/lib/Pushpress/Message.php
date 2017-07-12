<?php

class Pushpress_Message extends Pushpress_ApiResource
{
  public static function constructFrom($values, $apiKey=null)
  {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiKey);
  }

  public static function retrieve($id, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedRetrieve($class, $id, $apiKey);
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
  
  public static function Send($params, $apiKey=null) {
    $class = get_class();
    // self::_validateCall('all', $params, $apiKey);
    $requestor = new Pushpress_ApiRequestor($apiKey);
    
    $url = self::_scopedLsb($class, 'classUrl', $class);
    
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    return Pushpress_Util::convertToPushpressObject($response, $apiKey);
    
    
  }
  
  
  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedAll($class, $params, $apiKey);
  }
}
