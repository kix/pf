<?php
declare(strict_types=1);

namespace RouteFinder\SortingStrategy;

interface StrategyInterface
{
    public function sort(array $cards): array;
}