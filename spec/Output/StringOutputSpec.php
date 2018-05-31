<?php

namespace spec\RouteFinder\Output;

use RouteFinder\BoardingCard;
use RouteFinder\Output\OutputInterface;
use RouteFinder\Output\StringOutput;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RouteFinder\Route;

class StringOutputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StringOutput::class);
        $this->shouldImplement(OutputInterface::class);
    }

    function it_outputs_train_cards_without_seats_correctly()
    {
        $this->output(new Route([new BoardingCard(
            'Source',
            'Destination',
            'train',
            '78A'
        )]))->shouldBeEqualTo("Take train 78A from Source to Destination. No seat assignment.\nYou have arrived at your final destination.");
    }

    function it_outputs_train_cards_with_seats_correctly()
    {
        $this->output(new Route([new BoardingCard(
            'Source',
            'Destination',
            'train',
            '78A',
            '5C'
        )]))->shouldBeEqualTo("Take train 78A from Source to Destination. Take seat 5C.\nYou have arrived at your final destination.");
    }

    function it_processes_templates()
    {
        $this::renderTemplate(
            'Hello {name}, the weather is {conditions} {day}. It will be {temperature}° {day}.',
            [
                'name' => 'John',
                'conditions' => 'fine',
                'day' => 'today',
                'temperature' => 25
            ]
        )->shouldReturn(
            'Hello John, the weather is fine today. It will be 25° today.'
        );
    }
}
