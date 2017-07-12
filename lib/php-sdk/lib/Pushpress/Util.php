<?php

abstract class Pushpress_Util
{
  public static function isList($array)
  {
    if (!is_array($array))
      return false;

    // TODO: this isn't actually correct in general, but it's correct given Pushpress's responses
    foreach (array_keys($array) as $k) {
      if (!is_numeric($k))
        return false;
    }
    return true;
  }

  public static function convertPushpressObjectToArray($values)
  {
    $results = array();
    foreach ($values as $k => $v) {
      // FIXME: this is an encapsulation violation
      if ($k[0] == '_') {
        continue;
      }
      if ($v instanceof Pushpress_Object) {
        $results[$k] = $v->__toArray(true);
      }
      else if (is_array($v)) {
        $results[$k] = self::convertPushpressObjectToArray($v);
      }
      else {
        $results[$k] = $v;
      }
    }
    return $results;
  }

  public static function convertToPushpressObject($resp, $apiKey)
  {
    $types = array(
      'card' => 'Pushpress_Card',
      'charge' => 'Pushpress_Charge',
      'customer' => 'Pushpress_Customer',
      'list' => 'Pushpress_List',
      'invoice' => 'Pushpress_Invoice',
      'invoiceitem' => 'Pushpress_InvoiceItem',
      'event' => 'Pushpress_Event',
      'transfer' => 'Pushpress_Transfer',
      'plan' => 'Pushpress_Plan',
      'recipient' => 'Pushpress_Recipient',
      'subscription' => 'Pushpress_Subscription'
    );
    if (self::isList($resp)) {
      $mapped = array();
      foreach ($resp as $i)
        array_push($mapped, self::convertToPushpressObject($i, $apiKey));
      return $mapped;
    } else if (is_array($resp)) {
      if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']]))
        $class = $types[$resp['object']];
      else
        $class = 'Pushpress_Object';
      return Pushpress_Object::scopedConstructFrom($class, $resp, $apiKey);
    } else {
      return $resp;
    }
  }
}
