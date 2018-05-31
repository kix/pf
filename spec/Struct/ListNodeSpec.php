<?php

namespace spec\RouteFinder\Struct;

use RouteFinder\Struct\ListNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListNodeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Data', 'from', 'to');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ListNode::class);
    }

    function it_stores_data()
    {
        $this->beConstructedWith('Data', 'from', 'to');
        $this->getData()->shouldBeEqualTo('Data');
    }

    function it_stores_prev_key()
    {
        $this->beConstructedWith('Data', 'from', 'to');
        $this->getPrevKey()->shouldBeEqualTo('from');
    }

    function it_stores_next_key()
    {
        $this->beConstructedWith('Data', 'from', 'to');
        $this->getNextKey()->shouldBeEqualTo('to');
    }
}
