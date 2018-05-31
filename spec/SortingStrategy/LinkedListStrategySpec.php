<?php

namespace spec\RouteFinder\SortingStrategy;

use RouteFinder\BoardingCard;
use RouteFinder\SortingStrategy\LinkedListStrategy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RouteFinder\SortingStrategy\StrategyInterface;

class LinkedListStrategySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LinkedListStrategy::class);
        $this->shouldImplement(StrategyInterface::class);
    }

    function it_sorts_cards_correctly()
    {
        $sorted = [
            new BoardingCard('A', 'B', 'train'),
            new BoardingCard('B', 'C', 'train'),
            new BoardingCard('C', 'D', 'train'),
            new BoardingCard('D', 'E', 'train')
        ];

        $shuffled = $sorted;
        shuffle($shuffled);

        $this->sort($shuffled)->shouldReturn($sorted);
    }
}
