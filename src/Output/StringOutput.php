<?php

namespace RouteFinder\Output;

use RouteFinder\BoardingCard;
use RouteFinder\Route;

class StringOutput implements OutputInterface
{
    private const TEMPLATES = [
        'train' => 'Take {transportType} {transportId} from {source} to {destination}.',
        'the airport bus' => 'Take {transportType} from {source} to {destination}.',
        'flight' => 'From {source}, take {transportType} {transportId} to {destination}. Gate {gate}, seat {seat}.
{extraInfo}.'
    ];

    /**
     * @api
     * @param Route $route
     * @return mixed|string
     */
    public function output(Route $route)
    {
        $result = array_map([$this, 'outputCard'], $route->getRoute());
        $result []= 'You have arrived at your final destination.';

        return implode("\n", $result);
    }

    private function outputCard(BoardingCard $card)
    {
        $transportType = $card->getTransportType();

        if (!array_key_exists($transportType, self::TEMPLATES)) {
            throw new \InvalidArgumentException(sprintf(
                'No template available for transport type %s',
                $transportType
            ));
        }

        $template = self::TEMPLATES[$transportType];

        $note = self::renderTemplate($template, $card->toArray());

        if ($seat = $card->getSeat() ) {
            if (strpos($template, '{seat}') === false) {
                $note .= sprintf(' Take seat %s.', $seat);
            }
        } else {
            $note .= ' No seat assignment.';
        }

        $result []= $note;

        return implode(' ', $result);
    }

    public static function renderTemplate(string $template, array $arguments)
    {
        $result = $template;

        foreach ($arguments as $key => $value) {
            $result = str_replace('{'.$key.'}', $value, $result);
        }

        return $result;
    }
}
