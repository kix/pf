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
Check out the example at `bin/example`. A boarding card is represented by an instance of `RouteFinder\BoardingCard`. 
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

