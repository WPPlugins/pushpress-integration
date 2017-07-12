<?php

class Pushpress_Calendar extends Pushpress_ApiResource
{
    public static function classUrl($class=null) {
        return "/v1/calendar";
    }
    
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
  
  public static function inactive($apiKey=null)
  {
    $class = get_class();
    return self::_scopedInactive($class, $apiKey);
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
  
    public static function register($params=null) {
        $class = get_class();
        $url = self::classUrl($class);
        $url .= "/register";
        $requestor = new Pushpress_ApiRequestor();
      
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        return self::scopedConstructFrom($class, $response, $apiKey);    
    }
    
    public static function cancelRegistration($id) {
        $class = get_class();
        $url = self::classUrl($class);
        $url .= "/register/$id";
        $requestor = new Pushpress_ApiRequestor();
      
        list($response, $apiKey) = $requestor->request('delete', $url);
        return self::scopedConstructFrom($class, $response, $apiKey);
        
    }
    
    public static function getRegistrations($params=null) {
        $class = get_class();
        $url = self::classUrl($class);
        $url .= "/registrations";
        echo $url;
        $requestor = new Pushpress_ApiRequestor();
      
        list($response, $apiKey) = $requestor->request('get', $url, $params);
        return self::scopedConstructFrom($class, $response, $apiKey);
        
    }
  
}
