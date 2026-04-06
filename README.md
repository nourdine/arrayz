arrayz
======

### 1. Intro

This library allows you to navigate **associative multi-dimentional arrays** in depth, without having to worry about the existence of the keys you are trying to access.

### 2. Examples

Given an associative multi-dimentional array like the following:

```php
$data = [
   "a" => "a",
   "b" => "b",
   "c" => [
      "d" => "d",
      "e" => "e",
      "f" => [
         "g" => "g",
         "h" => "h",
         "i" => [1, 2, 3],
         "l" => ["hello", ["x", "y"]]
      ]
   ]      
];
```

You will be in the position to search values the following way:

```php
Arrayz::get("a", $data); // "a"
Arrayz::get("a > c > d", $data); // "d"
Arrayz::get("a > c > f > g", $data); // "g"
Arrayz::get("a > not > f > g", $data); // null
Arrayz::get("c > f > i > 0", $data); // 1
Arrayz::get("c > f > l > 1", $data); // ["x", "y"]
Arrayz::get("c > f > l > 1 > 0", $data); // "x"
```

### 3. Run unit tests

```
composer install
composer test
```

