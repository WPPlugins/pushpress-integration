<?php

class Pushpress_Subscriptions extends Pushpress_ApiResource
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
  
  public function update($params=array()) {
        $url =  $this->instanceUrl();
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
        
        return $response;
    }
  
  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedAll($class, $params, $apiKey);
  }
  
  public function getContract()
  {
     $url =  $this->instanceUrl() . '/contracts';
     $params = array();
      // echo '<br>options:<br>';
      // var_dump($params);
      $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
    list($response, $apiKey) = $requestor->request('get', $url, $params);
    //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $response;
  }
  
    public function cancel($params=array()) {
        $url =  $this->instanceUrl() . '/cancel';
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
        return $response;
    }
    
    public function charge($params=array()) {
        $url =  $this->instanceUrl() . '/charge';
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
        return $response;
    }
  
    public function saveContract($params=array()) {
        $url =  $this->instanceUrl() . '/contract';
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
        return $response;
    }
  
  
}
