<?php
declare(strict_types=1);

namespace RouteFinder\Struct\Exception;

use RouteFinder\Struct\ListNode;

class MalformedRouteException extends \LogicException
{
    public static function forNode(ListNode $node)
    {
        return new self(sprintf(
            'Bad node found: %s (from %s to %s)',
            (string) $node->getData(),
            $node->getPrevKey(),
            $node->getNextKey()
        ));
    }

    public static function forCircularDependency()
    {
        return new self('Circular dependency detected');
    }
}