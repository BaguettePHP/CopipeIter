<?php /* tadsan@pixiv.com | license WTFPL */

namespace Baguette\iter;

/**
 * @param  iterable|array|\Traversable $iter
 * @param  callable                    $callback
 * @return \Generator
 */
function map($iter, callable $callback)
{
    foreach ($iter as $k => $v) {
        yield $k => $callback($v);
    }
}

/**
 * @param  iterable|array|\Traversable $iter
 * @param  callable                    $callback
 * @return \Generator
 */
function map_kv($iter, callable $callback)
{
    foreach ($iter as $k => $v) {
        yield $k => $callback($k, $v);
    }
}

/**
 * @param  iterable|array|\Traversable $iter
 * @return array
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
 * @param  iterable|array|\Traversable $iter
 * @param  int                         $n
 * @return \Generator
 */
function take($iter, $n)
{
    $i = 0;
    foreach ($iter as $k => $x) {
        if ($n <= $i++) { break; }
        yield $k => $x;
    }
}
