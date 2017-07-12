<?php

class Pushpress_Preorder extends Pushpress_ApiResource
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
  
  public function sale($params=array()) {       
    $url =  $this->instanceUrl() . '/sale';
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    
        
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function getOrders() {       
    $url =  $this->instanceUrl() . '/orders';
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    
    list($response, $apiKey) = $requestor->request('get', $url);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function getOrder($preorder_sale_id) {       
    $url =  $this->instanceUrl() . '/order/'  . $preorder_sale_id;
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    
    list($response, $apiKey) = $requestor->request('get', $url);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
  public function updateOrder($params=array()) {       
    $url =  $this->instanceUrl() . '/order/' . $params['preorder_sale_id'];
    $requestor = new Pushpress_ApiRequestor($this->_apiKey);
    
    //echo $url;
    //echo '<pre>';
    //var_dump($params);
    // echo '</pre>';
    //die();
    
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
}
