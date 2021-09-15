<?php /* tadsan@pixiv.com | license WTFPL */

namespace Baguette\iter;

/**
 * @template K
 * @template V
 * @template T
 * @param array|\Traversable $iter
 * @phpstan-param iterable<K,V> $iter
 * @phpstan-param callable(V):T $callback
 * @return \Generator<K,T>
 */
function map($iter, callable $callback)
{
    foreach ($iter as $k => $v) {
        yield $k => $callback($v);
    }
}

/**
 * @template K
 * @template V
 * @template T
 * @param array|\Traversable $iter
 * @phpstan-param iterable<K,V> $iter
 * @phpstan-param callable(K,V):T $callback
 * @return \Generator<K,T>
 */
function map_kv($iter, callable $callback)
{
    foreach ($iter as $k => $v) {
        yield $k => $callback($k, $v);
    }
}

/**
 * @template K
 * @template V
 * @param array|\Traversable $iter
 * @phpstan-param iterable<K,V> $iter
 * @return array<K,V>
 */
function to_array($iter)
{
    if (is_array($iter)) {
        return $iter;
    }

    $ary = [];
    foreach ($iter as $i => $v) {
        $ary[$i] = $v;
    }

    return $ary;
}

/**
 * @template K
 * @template V
 * @param array|\Traversable $iter
 * @phpstan-param iterable<K,V> $iter
 * @param int $n
 * @phpstan-param positive-int $n
 * @return \Generator<K,V>
 */
function take($iter, $n)
{
    $i = 0;
    foreach ($iter as $k => $x) {
        if ($n <= $i++) { break; }
        yield $k => $x;
    }
}

/**
 * @template K
 * @template V
 * @param array|\Traversable $iter
 * @phpstan-param iterable<K,V> $iter
 * @param int $start
 * @phphstan-param positive-int $start
 * @param int|float $len
 * @phphstan-param positive-int|float $len
 * @return \Generator<K,V>
 */
function slice($iter, $start, $len = INF)
{
    $i = 0;
    foreach ($iter as $k => $x) {
        if ($i >= $start + $len) { break; }
        if ($i++ >= $start) {
            yield $k => $x;
        }
    }
}
