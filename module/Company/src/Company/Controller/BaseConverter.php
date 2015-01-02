<?php

namespace Company\Controller;

abstract class BaseConverter {
  /**
   *
   * @param unknown $entities          
   * @return multitype:|multitype:NULL
   */
  public function toJson($entities) {
    if (! $entities) {
      return array ();
    }
    
    if (is_array($entities)) {
      $result = array ();
      foreach ( $entities as $e ) {
        array_push($result, $this->entityToJson($e));
      }
      return $result;
    } else {
      return $this->entityToJson($entities);
    }
  }
  
  
  abstract function entityToJson($entity);
}