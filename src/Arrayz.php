<?php

declare(strict_types=1);

namespace Arrayz;

use RuntimeException;

class Arrayz
{
   /**
    * Safely get a value of the provided array
    */
   public static function get(string $path, array $data): mixed
   {
      $path = self::stripWhiteSpace($path);
      self::checkPath($path);
      $keys = explode(">", $path);
      for ($i = 0; $i < count($keys); $i++) {
         $currentKey = $keys[$i];
         if (is_array($data) && array_key_exists($currentKey, $data)) {
            $data = $data[$currentKey];
            // I am at the end of the path...
            if ($i === count($keys) - 1) {
               return $data;
            }
         } else {
            // The current data source is not an array or the key does not exist in it.
            // Journey is over... we didn't make it!
            break;
         }
      }
      return null;
   }

   private static function checkPath(string $path): void
   {
      if (empty(trim($path))) {
         throw new RuntimeException("The path is empty");
      }
   }

   private static function stripWhiteSpace(string $str)
   {
      return preg_replace('/\s+(?=(?:[^"]*"[^"]*")*[^"]*$)/', '', $str);
   }
}
