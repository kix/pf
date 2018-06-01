<?php

declare(strict_types=1);

namespace RouteFinder\Struct;

use RouteFinder\Struct\Exception\MalformedRouteException;

class LinkedList
{
    /**
     * @var ListNode
     */
    private $firstNode;

    /**
     * LinkedList constructor.
     *
     * @param array $cards
     */
    public function __construct(array $cards)
    {
        /** @var ListNode[] $sorted */
        $sorted = [];

        foreach ($cards as $card) {
            $sorted[] = new ListNode($card['value'], $card['prev'], $card['next']);
        }

        foreach ($sorted as $node) {
            foreach ($sorted as $k => $node2) {
                if ($node2->getNext() && $node2->getPrevious()) {
                    unset($sorted[$k]);
                }

                if ($node2->getNextKey() == $node->getPrevKey()) {
                    $node2->setNext($node);
                } elseif ($node2->getPrevKey() == $node->getNextKey()) {
                    $node->setNext($node2);
                }
            }

            if (null === $node->getPrevious()) {
                $this->firstNode = $node;
            }

            if (!$node->getNext() && !$node->getPrevious()) {
                throw MalformedRouteException::forNode($node);
            }
        }

        if (!$this->firstNode) {
            throw MalformedRouteException::forCircularDependency();
        }
    }

    public function toArray()
    {
        $currentNode = $this->firstNode;
        $result = [$currentNode->getData()];

        while ($nextNode = $currentNode->getNext()) {
            $currentNode = $nextNode;
            $result[] = $nextNode->getData();
        }

        return $result;
    }
}
