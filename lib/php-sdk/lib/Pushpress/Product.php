<?php

class Pushpress_Product extends Pushpress_ApiResource
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
  
  public function createPreorder()
  {
     $url =  $this->instanceUrl();
     $url = str_replace($this->id, '', $url);
     $url  .= 'preorder';
     
     $params = array(
        "id" => $this->id
      );
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function saveImage($image=array())
  {
       
     $url =  $this->instanceUrl() . '/image';
     
     $params = array(
        "name"        => $image['id'],
        "filename" => $image['filename'],
        "position" => $image['position']
      );
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function saveOption($option=array())
  {
     $url =  $this->instanceUrl() . '/option';
     
     $params = array(
        "name"        => $option['name'],
        "price" => $option['price'],
        "id" => isset($option['id']) ? $option['id'] : 0,
        "order" =>  isset($option['order']) ? $option['order']: 1,
        "inventory" => isset($option['inventory']) ? $option['inventory']: null,
        "cost" => isset($option['cost']) ? $option['cost']: null,
      );
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function deleteOption($id)
  {
     $url =  $this->instanceUrl() . '/option/' . $id;
     $params = array();
      // echo '<br>options:<br>';
      // var_dump($params);
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
    list($response, $apiKey) = $requestor->request('delete', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function getOption($id)
  {
     $url =  $this->instanceUrl() . '/option/' . $id;
     $params = array();
      // echo '<br>options:<br>';
      // var_dump($params);
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
    list($response, $apiKey) = $requestor->request('get', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
}
