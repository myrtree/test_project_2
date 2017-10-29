<?php

namespace App\Http\Controllers\Api\v1;

use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class Controller extends LaravelController
{
    use EloquentBuilderTrait;

    public function queryByUrlParameters($query)
    {
        $resourceOptions = $this->parseResourceOptions();
        $this->applyResourceOptions($query, $resourceOptions);
        $parsedData = $this->parseData($query->get(), $resourceOptions);

        return $parsedData;
    }
}
