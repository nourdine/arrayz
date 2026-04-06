<?php

declare(strict_types=1);

use Arrayz\Arrayz;
use PHPUnit\Framework\TestCase;

class ArrayzTest extends TestCase
{
   private static $data = [
      "a" => "a",
      "b" => "b",
      "c" => [
         "d" => "d",
         "e" => "e",
         "f" => [
            "g" => "g",
            "h" => "h",
            "i" => [1, 2, 3],
            "l" => [15 + 18, ["x", "y"]]
         ]
      ]
   ];

   public function testEmptyPath1()
   {
      $this->expectException(RuntimeException::class);
      Arrayz::get("", self::$data);
   }

   public function testEmptyPath2()
   {
      $this->expectException(RuntimeException::class);
      Arrayz::get("   ", self::$data);
   }

   public function testPathWithRandomWhiteSpace()
   {
      $this->assertEquals("d", Arrayz::get("  c >   d   ", self::$data));
      $this->assertEquals("g", Arrayz::get("  c   > f    > g    ", self::$data));
   }

   public function testPathToPrimitives()
   {
      $this->assertEquals("a", Arrayz::get("a", self::$data));
      $this->assertEquals("b", Arrayz::get("b", self::$data));
      $this->assertEquals("d", Arrayz::get("c > d", self::$data));
      $this->assertEquals("d", Arrayz::get("c > d", self::$data));
      $this->assertEquals("d", Arrayz::get("c > d", self::$data));
      $this->assertEquals("e", Arrayz::get("c > e", self::$data));
      $this->assertEquals("g", Arrayz::get("c > f > g", self::$data));
      $this->assertEquals("h", Arrayz::get("c > f > h", self::$data));
   }

   public function testPathToArray()
   {
      $this->assertTrue(is_array(Arrayz::get("c > f", self::$data)));
      $this->assertTrue(is_array(Arrayz::get("c > f > i", self::$data)));
   }

   public function testPathToValueInIndexedArray()
   {
      $this->assertEquals(1, Arrayz::get("c > f > i > 0", self::$data));
      $this->assertEquals(33, Arrayz::get("c > f > l > 0", self::$data));
      $this->assertEquals(33, Arrayz::get("c > f > l > 0", self::$data));
      $this->assertTrue(is_array(Arrayz::get("c > f > l > 1", self::$data)));
      $this->assertEquals("x", Arrayz::get("c > f > l > 1 > 0", self::$data));
   }

   public function testBrokenPath()
   {
      $this->assertEquals(null, Arrayz::get("not", self::$data));
      $this->assertEquals(null, Arrayz::get("a > not", self::$data));
      $this->assertEquals(null, Arrayz::get("c > f > not", self::$data));
      $this->assertEquals(null, Arrayz::get("c > not > x", self::$data));
   }
}
