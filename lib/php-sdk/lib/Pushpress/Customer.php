<?php

class Pushpress_Customer extends Pushpress_ApiResource
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
  
  public function CreateWaiver($params, $apiKey) {
        
  }
  
  public function setPin($params=null) {
        $url = $this->instanceUrl();
        $url .= "/pin";
        $requestor = new Pushpress_ApiRequestor();
      
        list($response, $apiKey) = $requestor->request('post', $url, $params);
        $this->refreshFrom($response, $apiKey);
        return $this;
  }
  
  
  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedAll($class, $params, $apiKey);
  }
  
    public function subscriptions($params=null, $apiKey=null) {
              
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        $url = $this->instanceUrl() . '/subscriptions';
        
        list($response, $apiKey) = $requestor->request('get', $url, $params);
        $this->refreshFrom($response, $apiKey);
        return $this;
  }
    public function billing($params=null, $apiKey=null) {
              
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        $url = $this->instanceUrl() . '/billing';
        
        
        list($response, $apiKey) = $requestor->request('get', $url, $params);
        $this->refreshFrom($response, $apiKey);
        return $this;
  }
    
    public function leadfunnel($params=null, $apiKey=null) {
              
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        $url = $this->instanceUrl() . '/leadfunnel';
        
        list($response, $apiKey) = $requestor->request('get', $url, $params);
        $this->refreshFrom($response, $apiKey);
        return $this;
  }
	
	public function leadupdate($params=null) {
              
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        $url = $this->instanceUrl() . '/leadfunnel';
		list($response, $apiKey) = $requestor->request('post', $url, $params);
        $this->refreshFrom($response, $apiKey);
		
		return $this;
  	}
    
    public function leads($params=null, $apiKey=null) {
              
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        $url = $this->instanceUrl() . '/leads';
        
        list($response, $apiKey) = $requestor->request('get', $url, $params);
        $this->refreshFrom($response, $apiKey);
        return $this;
  }
      
    
    public function appendableInvoice($params=null, $apiKey=null) {
              
        $requestor = new Pushpress_ApiRequestor($this->_apiKey);
        $url = $this->instanceUrl() . '/invoice/appendable';
        list($response, $apiKey) = $requestor->request('get', $url, $params);
        $this->refreshFrom($response, $apiKey);
        return $this;
    }
       
}
