<?php

class Pushpress_Contracts extends Pushpress_ApiResource
{
    
  public static function constructFrom($values, $apiKey=null)
  {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiKey);
  }

  public static function retrieve($id, $params=array(), $apiKey=null)
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
  
  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedAll($class, $params, $apiKey);
  }
  
  public static function retrieveEmpty($id=null, $apiKey=null)
  {      
    $class = get_class();
    return self::_scopedRetrieveEmpty($class, $id, $apiKey);
  }

  public function customers($params=null)
  {
        $url =  $this->instanceUrl() . '/customers/' . $params['active'];
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
        list($response, $apiKey) = $requestor->request('get', $url);
        return Pushpress_Util::convertToPushpressObject($response, $apiKey);
        
  }
  
  
  public function attachPlans($plan_ids=null)
  {
        $url =  $this->instanceUrl() . '/plans';
        $params = array(
            "plan_ids" => $plan_ids
        );
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        //$this->refreshFrom(array('subscription' => $response), $apiKey, true);
        return $response;
  }
   

}
