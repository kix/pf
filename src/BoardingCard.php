<?php

namespace RouteFinder;

class BoardingCard
{
    private $source;

    private $destination;

    private $transportType;

    private $transportId;

    private $seat;

    private $gate;

    private $extraInfo;

    /**
     * BoardingCard constructor.
     *
     * @api
     *
     * @param string $source
     * @param string $destination
     * @param string $transportType
     * @param string $transportId
     * @param string $seat
     * @param string $gate
     * @param string $extraInfo
     */
    public function __construct(string $source, string $destination, string $transportType, string $transportId = null, string $seat = null, string $gate = null, string $extraInfo = null)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->transportType = $transportType;
        $this->transportId = $transportId;
        $this->seat = $seat;
        $this->gate = $gate;
        $this->extraInfo = $extraInfo;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getTransportType()
    {
        return $this->transportType;
    }

    /**
     * @return string
     */
    public function getTransportId()
    {
        return $this->transportId;
    }

    /**
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @return string
     */
    public function getGate()
    {
        return $this->gate;
    }

    /**
     * @return string
     */
    public function getExtraInfo()
    {
        return $this->extraInfo;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
