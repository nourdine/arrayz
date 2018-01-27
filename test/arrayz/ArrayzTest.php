<?php

use arrayz\Arrayz;
use PHPUnit\Framework\TestCase;

class ArrayzTest extends TestCase {

   private static $data = array(
      "a" => "a",
      "b" => "b",
      "c" => array(
         "d" => "d",
         "e" => "e",
         "f" => array(
            "g" => "g",
            "h" => "h"
         )
      ),
   );

   /**
    * @expectedException RuntimeException
    */
   public function testEmptyKey() {
      Arrayz::get("   ", self::$data);
   }

   /**
    * @expectedException RuntimeException
    */
   public function testWrongTypeKey() {
      Arrayz::get(array(), self::$data);
   }

   public function testGet() {
      $this->assertEquals("a", Arrayz::get("a", self::$data));
      $this->assertEquals("b", Arrayz::get("b", self::$data));
      $this->assertEquals("d", Arrayz::get("c>d", self::$data));
      $this->assertEquals("d", Arrayz::get("c > d", self::$data));
      $this->assertEquals("d", Arrayz::get("c  >  d", self::$data));
      $this->assertEquals("e", Arrayz::get("c>e", self::$data));
      $this->assertEquals("g", Arrayz::get("c>f>g", self::$data));
      $this->assertEquals("h", Arrayz::get("c>f>h", self::$data));
      $this->assertEquals(null, Arrayz::get("not", self::$data));
      $this->assertEquals(null, Arrayz::get("a>not", self::$data));
      $this->assertEquals(null, Arrayz::get("c>f>not", self::$data));
   }
}