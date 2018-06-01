<?php

namespace RouteFinder\SortingStrategy;

use RouteFinder\BoardingCard;
use RouteFinder\Struct\LinkedList;

class LinkedListStrategy implements StrategyInterface
{
    /**
     * @param BoardingCard[] $cards
     *
     * @return array
     */
    public function sort(array $cards): array
    {
        $items = [];

        foreach ($cards as $card) {
            $items[] = [
                'value' => $card,
                'prev' => $card->getSource(),
                'next' => $card->getDestination(),
            ];
        }

        return (new LinkedList($items))->toArray();
    }
}
