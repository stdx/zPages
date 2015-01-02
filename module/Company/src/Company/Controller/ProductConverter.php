<?php

namespace Company\Controller;

use Company\Entity\Product;

class ProductConverter extends BaseConverter {
  
  /**
   *
   * @var Product $entity
   *     
   */
  public function entityToJson($entity) {
    $dto = array (
        'id' => $entity->getId(),
        'company_id' => $entity->getCompany()->getId(),
        'template_id' => $entity->getTemplate()->getId()
    );
    return $dto;
  }
}