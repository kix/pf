<?php

namespace RouteFinder;

use RouteFinder\SortingStrategy\LinkedListStrategy;
use RouteFinder\SortingStrategy\StrategyInterface;

class Route
{
    /**
     * @var BoardingCard[]
     */
    private $route;

    /**
     * Route constructor.
     *
     * @api
     *
     * @param BoardingCard[]         $cards
     * @param StrategyInterface|null $strategy
     */
    public function __construct(array $cards, StrategyInterface $strategy = null)
    {
        foreach ($cards as $card) {
            if (!$card instanceof BoardingCard) {
                throw new \InvalidArgumentException(sprintf(
                    'Expected a BoardingCard instance, got %s',
                    is_object($card)
                        ? get_class($card)
                        : gettype($card)
                ));
            }
        }

        if (!$strategy) {
            $strategy = new LinkedListStrategy();
        }

        $this->route = $cards;

        if (count($cards) > 1) {
            $this->route = $strategy->sort($this->route);
        }
    }

    /**
     * @api
     *
     * @return BoardingCard[]
     */
    public function getRoute(): array
    {
        return $this->route;
    }
}
