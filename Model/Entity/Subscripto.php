<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity @Table(name="subscripto")
 **/
class Subscripto
{
  /**
    * @Id @Column(name="chat_id", type="integer")
   * @var integer
  */
    protected $chat_id;

    public function getChat_Id() {
      return $this->chat_id;
    }

    public function setChat_Id($chat_id) {
      $this->chat_id = $chat_id;
    }
}
?>
