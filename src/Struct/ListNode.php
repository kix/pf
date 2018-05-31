<?php
declare(strict_types=1);

namespace RouteFinder\Struct;

class ListNode
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var ListNode
     */
    private $next;

    /**
     * @var ListNode
     */
    private $previous;

    /**
     * @var string
     */
    private $prevKey;

    /**
     * @var string
     */
    private $nextKey;

    /**
     * ListNode constructor.
     * @param mixed $data
     */
    public function __construct($data, string $prevKey, string $nextKey)
    {
        $this->data = $data;
        $this->prevKey = $prevKey;
        $this->nextKey = $nextKey;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getPrevKey(): string
    {
        return $this->prevKey;
    }

    /**
     * @return string
     */
    public function getNextKey(): string
    {
        return $this->nextKey;
    }

    /**
     * @return ListNode
     */
    public function getNext(): ?ListNode
    {
        return $this->next;
    }

    /**
     * @param ListNode $next
     */
    public function setNext(ListNode $next): void
    {
        $this->next = $next;
        $next->previous = $this;
    }

    /**
     * @return ListNode
     */
    public function getPrevious(): ?ListNode
    {
        return $this->previous;
    }

    /**
     * @param ListNode $previous
     */
    public function setPrevious(ListNode $previous): void
    {
        $this->previous = $previous;
        $previous->next = $this;
    }
}