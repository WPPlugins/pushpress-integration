<?php

class Pushpress_ProductImages extends Pushpress_ApiResource
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
  
  public function createPreorder()
  {
     $url =  $this->instanceUrl();
     $url = str_replace($this->id, '', $url);
     $url  .= 'preorder';
     
     $params = array(
        "id" => $this->id
      );
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    echo 'createPreorder url: ' . $url;
    var_dump($params);
        
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    echo "response" . 
    var_dump( $response);
    return $response;
  }
  
  public function saveImages($images=array())
  {
     $url =  $this->instanceUrl() . '/images';
     
     $params = array(
        "images" => $images
      );
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    echo 'saveImages url: ' . $url;
    var_dump($params);
        
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    echo "response" . 
    var_dump( $response);
    return $response;
  }
  
}
