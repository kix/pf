<?php

namespace spec\RouteFinder;

use Prophecy\Prediction\CallPrediction;
use Prophecy\Prophet;
use RouteFinder\BoardingCard;
use RouteFinder\Route;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RouteFinder\SortingStrategy\StrategyInterface;

class RouteSpec extends ObjectBehavior
{
    function let(BoardingCard $card, StrategyInterface $strategy)
    {
        $this->beConstructedWith([$card, $card], $strategy);
        $strategy->sort([$card, $card])->willReturn([$card, $card]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Route::class);
    }

    function it_allows_only_cards_as_first_argument(BoardingCard $card, StrategyInterface $strategy)
    {
        $this->beConstructedWith([$card, 'string'], $strategy);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_sorts_with_the_provided_strategy()
    {
        $strategy = (new Prophet())->prophesize(StrategyInterface::class);
        $strategy->sort(Argument::any())->should(new CallPrediction());

        $route = new Route([
            new BoardingCard('A', 'B', 'C'),
            new BoardingCard('A', 'B', 'C')
        ], $strategy->reveal());

        $strategy->checkProphecyMethodsPredictions();
    }

    function it_does_not_sort_when_there_s_only_one_card(BoardingCard $card, StrategyInterface $strategy)
    {
        $this->beConstructedWith([$card, $card], $strategy);
        $strategy->sort()->shouldNotHaveBeenCalled();
    }
}
