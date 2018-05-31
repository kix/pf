<?php

namespace spec\RouteFinder;

use RouteFinder\BoardingCard;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BoardingCardSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(
            'Madrid',
            'Barcelona',
            'train',
            '78A',
            '45B'
        );
        $this->shouldHaveType(BoardingCard::class);
    }

    function it_returns_source()
    {
        $this->beConstructedWith(
            'Madrid',
            'Barcelona',
            'train',
            '78A'
        );

        $this->getSource()->shouldReturn('Madrid');
    }

    function it_returns_destination()
    {
        $this->beConstructedWith(
            'Madrid',
            'Barcelona',
            'train',
            '78A'
        );

        $this->getDestination()->shouldReturn('Barcelona');
    }

    function it_returns_transport_type()
    {
        $this->beConstructedWith(
            'Madrid',
            'Barcelona',
            'train',
            '78A'
        );

        $this->getTransportType()->shouldReturn('train');
    }

    function it_returns_transport_id()
    {
        $this->beConstructedWith(
            'Madrid',
            'Barcelona',
            'train',
            '78A'
        );

        $this->getTransportId()->shouldReturn('78A');
    }

    function it_returns_seat()
    {
        $this->beConstructedWith(
            'Madrid',
            'Barcelona',
            'train',
            '78A',
            '45B'
        );

        $this->getSeat()->shouldReturn('45B');
    }
}
