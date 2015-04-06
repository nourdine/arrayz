<?php

namespace arrayz;

class Arrayz {

   protected static function sanitize($k) {
      if (!is_string($k)) {
         throw new \RuntimeException("The key must be a string");
      } else {
         $k = trim($k);
         if (empty($k)) {
            throw new \RuntimeException("The key is empty");
         }
         return $k;
      }
   }

   /**
    * Get an (however deep) array value safely
    * @param string $key
    * @param array $data
    * @return mixed
    */
   public static function get($key, array $data) {
      $key = self::sanitize($key);
      $keys = preg_split("/[\s]{0,}>[\s]{0,}/", $key);
      for ($i = 0; $i < count($keys); $i++) {
         $currentKey = $keys[$i];
         if (is_array($data)) {
            if (array_key_exists($currentKey, $data)) {
               $data = $data[$currentKey];
            } else {
               return null;
            }
         } else {
            return null;
         }
      }
      return $data;
   }
}