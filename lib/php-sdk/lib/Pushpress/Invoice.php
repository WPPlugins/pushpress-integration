<?php

class Pushpress_Invoice extends Pushpress_ApiResource
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
  
  public function saveItem($item=array())
  {       
     $url =  $this->instanceUrl() . '/item';
     $params = $item;
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }

  public function deleteItem($invoice_item_id) 
  {       
      $url =  $this->instanceUrl() . '/item/' . $invoice_item_id;
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
      list($response, $apiKey) = $requestor->request('delete', $url);
      return $response;
  }
  
  public function charge($params=array()) {       
    $url =  $this->instanceUrl() . '/charge';
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    // echo $url;
    // echo '<br>';
    // var_dump($params);
    // die();
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
}
