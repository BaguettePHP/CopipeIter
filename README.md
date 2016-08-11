Copipe Iter
===========

Most simple iterators.

I do not claim the right for this project.  This package is licensed under [WTFPL](http://www.wtfpl.net/).

## API

### `Generator map(iterable $iter, callable $callback)`

```php
$data = [1, 2, 3];
$twice = function ($n) { return $n * 2 };

foreach (map($data, $twice) as $a) {
    echo $a, PHP_EOL;
}
// [output] 2, 4, 6
```

### `Generator map_kv(iterable $iter, callable $callback)`

```php
$data = ['apple', 'orange', 'strawberry'];
$deco = function ($k, $v) { return "{$k}: $v"; };

foreach (map_kv($data, $deco) as $a) {
    echo $a, PHP_EOL;
}
// [output] "1: apple", "2: orange", "3: strawberry"
```

### `Generator take(iterable $iter, int $n)`

```php
$data = range(1, 100);

foreach (take($data, 5) as $a) {
    echo $a, PHP_EOL;
}
// [output] 1, 2, 3, 4, 5
```

### `array to_array(iterable $iter)`

```php
$fib = function () {
    $n = 0; yield $n;
    $m = 1; yield $m;

    while (true) {
        $c = $n + $m;
        yield $c;
        $n = $m;
        $m = $c;
    }
};

$fib_10 = to_array(take($fib(), 10));
//=> [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]
```
