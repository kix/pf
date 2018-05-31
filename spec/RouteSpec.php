<?php

namespace spec\RouteFinder;

use RouteFinder\BoardingCard;
use RouteFinder\Route;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RouteFinder\SortingStrategy\EmptyStrategy;
use RouteFinder\SortingStrategy\StrategyInterface;

class RouteSpec extends ObjectBehavior
{
    function it_is_initializable(BoardingCard $card)
    {
        $this->beConstructedWith([$card]);

        $this->shouldHaveType(Route::class);
    }

    function it_allows_only_cards_as_first_argument(BoardingCard $card)
    {
        $this->beConstructedWith([$card, 'string']);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_sorts_with_the_provided_strategy(BoardingCard $card, $strategy)
    {
        $strategy->beADoubleOf(StrategyInterface::class);
        $strategy->sort(Argument::cetera())->willReturn([$card, $card])->shouldBeCalled();
        $this->beConstructedWith([$card, $card], $strategy);
    }

    function it_does_not_sort_when_there_s_only_one_card(BoardingCard $card, StrategyInterface $strategy)
    {
        $this->beConstructedWith([$card, $card], $strategy);
        $strategy->sort(Argument::cetera())->shouldNotHaveBeenCalled();
    }
}
