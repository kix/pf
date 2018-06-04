<?php

namespace spec\RouteFinder\Struct;

use RouteFinder\Struct\LinkedList;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RouteFinder\Struct\Exception\MalformedRouteException;

class LinkedListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([
            [
                'prev' => 'a',
                'next' => 'b',
                'value' => 1,
            ],
            [
                'prev' => 'b',
                'next' => 'c',
                'value' => 2,
            ],
            [
                'prev' => 'c',
                'next' => 'd',
                'value' => 3,
            ],
            [
                'prev' => 'd',
                'next' => 'e',
                'value' => 4,
            ]
        ]);

        $this->shouldHaveType(LinkedList::class);
    }

    function it_can_be_converted_to_array()
    {
        $array = [
            [
                'prev' => 'a',
                'next' => 'b',
                'value' => 1,
            ],
            [
                'prev' => 'b',
                'next' => 'c',
                'value' => 2,
            ],
            [
                'prev' => 'c',
                'next' => 'd',
                'value' => 3,
            ],
            [
                'prev' => 'd',
                'next' => 'e',
                'value' => 4,
            ]
        ];

        shuffle($array);

        $this->beConstructedWith($array);
        $this->toArray()->shouldBeEqualTo([1,2,3,4]);
    }

    function it_accepts_text_links()
    {
        $array = [
            [
                'prev' => 'Madrid',
                'next' => 'Barcelona',
                'value' => 'Madrid → Barcelona',
            ],
            [
                'prev' => 'Barcelona',
                'next' => 'Gerona Airport',
                'value' => 'Barcelona → Gerona',
            ],
            [
                'prev' => 'Gerona Airport',
                'next' => 'Stockholm',
                'value' => 'Gerona → Stockholm',
            ],
            [
                'prev' => 'Stockholm',
                'next' => 'New York',
                'value' => 'Stockholm → New York',
            ],
        ];

        shuffle($array);

        $this->beConstructedWith($array);
        $this->toArray()->shouldBeEqualTo(['Madrid → Barcelona','Barcelona → Gerona', 'Gerona → Stockholm', 'Stockholm → New York']);
    }

    function it_throws_for_incomplete_graphs()
    {
        $array = [
            [
                'prev' => 'Madrid',
                'next' => 'Barcelona',
                'value' => 'Madrid → Barcelona',
            ],
            [
                'prev' => 'Gerona Airport',
                'next' => 'Stockhold',
                'value' => 'Gerona → Stockholm',
            ],
            [
                'prev' => 'Stockholm',
                'next' => 'New York',
                'value' => 'Stockholm → New York',
            ],
        ];

        $this->beConstructedWith($array);
        $this->shouldThrow(MalformedRouteException::class)->duringInstantiation();
    }

    function it_throws_for_circular_dependencies()
    {
        $array = [
            [
                'prev' => 'a',
                'next' => 'b',
                'value' => 1,
            ],
            [
                'prev' => 'b',
                'next' => 'c',
                'value' => 2,
            ],
            [
                'prev' => 'c',
                'next' => 'd',
                'value' => 3,
            ],
            [
                'prev' => 'd',
                'next' => 'a',
                'value' => 4,
            ]
        ];

        $this->beConstructedWith($array);
        $this->shouldThrow(MalformedRouteException::class)->duringInstantiation();
    }
}
