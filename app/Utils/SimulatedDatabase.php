<?php

namespace App\Utils;

use Exception;

class SimulatedDatabase
{
    private $maxConnections;
    private $openConnections = 0;

    public function __construct($maxConnections)
    {
        $this->maxConnections = $maxConnections;
    }

    public function openConnection()
    {
        if ($this->openConnections >= $this->maxConnections) {
            throw new Exception("Max connection limit reached");
        }

        $this->openConnections++;
    }

    public function closeConnection()
    {
        $this->openConnections--;
    }

    public function executeQuery($query)
    {
        if (rand(0, 1) === 0) {
            throw new Exception("Database connection lost");
        }

        // Perform the query here
        return "Query result";
    }
}
