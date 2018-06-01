# Installation
Clone the repo and CD into it:
```
$ git clone git@github.com:kix/pf.git 
$ cd pf
```
Install the dependencies:
```
$ composer install
```
Run the example:
```
$ bin/example
```

The tests are using PHPSpec. To run those, execute:
```
$ vendor/bin/phpspec run --format=pretty
```

# Usage
## Logic
Check out the example at [`bin/example`](https://github.com/kix/pf/blob/master/bin/example). A boarding card is represented by an instance of [`RouteFinder\BoardingCard`](https://github.com/kix/pf/blob/master/src/BoardingCard.php#L24). 
It accepts the departure and destination as arguments, as well as all the other data that the boarding card might have:

```php
use RouteFinder\BoardingCard;

$card = new BoardingCard('Gerona Airport', 'Stockholm', 'flight', 'SK455', '3A', '45B', 'Baggage drop at ticket counter 344');
```

A collection of boarding cards makes a route:

```php
use RouteFinder\BoardingCard;
use RouteFinder\Route;

$route = new Route([
    new BoardingCard('Madrid', 'Barcelona', 'train', '78A', '45B'),
    new BoardingCard('Barcelona', 'Gerona Airport', 'the airport bus'),
    new BoardingCard('Gerona Airport', 'Stockholm', 'flight', 'SK455', '3A', '45B', 'Baggage drop at ticket counter 344'),
    new BoardingCard('Stockholm', 'New York JFK', 'flight', 'SK22', '7B', '22', 'Baggage will we automatically transferred from your last leg'),
]);
```

You can also pass a sorting strategy as the second parameter, e.g.:

```php
use RouteFinder\BoardingCard;
use RouteFinder\Route;
use RouteFinder\SortingStrategy\StrategyInterface;

$route = new Route([
    new BoardingCard('Madrid', 'Barcelona', 'train', '78A', '45B'),
], new class implements StrategyInterface {
    public function sort(array $cards): array 
    {
        // ...
    }
});
```

The default sorting strategy acts as an adapter between the data and a [plain PHP implementation of a linked list](https://github.com/kix/pf/blob/master/src/Struct/LinkedList.php):

```php
class LinkedListStrategy implements StrategyInterface
{
    /**
     * @param BoardingCard[] $cards
     * @return array
     */
    public function sort(array $cards): array
    {
        $items = [];

        foreach ($cards as $card) {
            $items []= [
                'value' => $card,
                'prev' => $card->getSource(),
                'next' => $card->getDestination(),
            ];
        }

        return (new LinkedList($items))->toArray();
    }
}
```

## Output
The output is handled by classes that implement [`RouteFinder\Output\OutputInterface`](https://github.com/kix/pf/blob/master/src/Output/OutputInterface.php). An example [`StringOutput`]((https://github.com/kix/pf/blob/master/src/Output/StringOutput.php)) handles
plain-text output that uses a basic string-based template engine. You can output a route like so:
```php
use RouteFinder\BoardingCard;
use RouteFinder\Route;
use RouteFinder\Output\StringOutput;

$route = new Route([
    new BoardingCard('Madrid', 'Barcelona', 'train', '78A', '45B'),
    new BoardingCard('Barcelona', 'Gerona Airport', 'the airport bus'),
    new BoardingCard('Gerona Airport', 'Stockholm', 'flight', 'SK455', '3A', '45B', 'Baggage drop at ticket counter 344'),
    new BoardingCard('Stockholm', 'New York JFK', 'flight', 'SK22', '7B', '22', 'Baggage will we automatically transferred from your last leg'),
]);

echo (new StringOutput())->output($route));
```

# Notes
All of the endpoints for the API are annotated with `@api`. These include:
- constructor for [`BoardingCard`](https://github.com/kix/pf/blob/master/src/BoardingCard.php#L24)
- constructor for [`Route`](https://github.com/kix/pf/blob/master/src/Route.php#L18)
- [`Route#getRoute()`](https://github.com/kix/pf/blob/master/src/Route.php#L48)
- [`RouteFinder\Output\StringOutput`](https://github.com/kix/pf/blob/master/src/Output/StringOutput.php)

# Assumptions
```
The list should be defined in a format that's compatible with the input format.
```
I've treated this requirement as if I'm allowed to pick a storage/data exchange format for the module. Thus, the output
is implemented as a separate structure that does not modify the models in any way. The data is stored as-is.

```
Be prepared to suggest to us how we could extend the code towards new types of transportation, which might have different
characteristics.
```
The main characteristic of a commute here is source and destination. Other characteristics could be either added as 
fields to the [`BoardingCard`](https://github.com/kix/pf/blob/master/src/BoardingCard.php) class, or as value objects, although at this point I see no need for that. 
Also, this might require adding a more sophisticated output logic, maybe a template engine that allows branching.

```
The implementation of your sorting algorithm should work with any set of boarding passes, as long as there is always an 
unbroken chain between all the legs of the trip. i.e. it's one continuous trip with no interruptions.
```
[An exception is thrown](https://github.com/kix/pf/blob/master/spec/Struct/LinkedListSpec.php#L102) if a route cannot be linked together. Circular dependencies [cause an exception too](https://github.com/kix/pf/blob/master/spec/Struct/LinkedListSpec.php#L126).