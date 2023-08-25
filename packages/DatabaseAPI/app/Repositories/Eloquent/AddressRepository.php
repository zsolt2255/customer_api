<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Repositories\Eloquent\Contracts\AddressRepositoryInterface;

class AddressRepository extends EloquentRepository implements AddressRepositoryInterface
{
    public function __construct(Address $model)
    {
        parent::__construct($model);
    }
}
