<?php

namespace Company\Controller;

class ProductTemplateConverter extends BaseConverter {
  
  /**
   * 
   * @param unknown $entity
   * @return multitype:NULL
   */
  public function entityToJson($entity) {
    $dto = array (
        'id' => $entity->getId(),
        'name' => $entity->getName()
    );
    
    if ($entity->getDescription()) {
      $dto ['description'] = $entity->getDescription();
    }
    
    return $dto;
  }
  
}