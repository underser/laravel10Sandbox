<?php
declare(strict_types=1);

namespace App\States\Project;

use App\Exceptions\StateException;
use App\Models\Project;

class BaseProjectState implements ProjectStateInterface
{
    public function __construct(protected Project $project)
    {}

    /**
     * @throws StateException
     */
    public function open(): void
    {
        throw new StateException();
    }

    /**
     * @throws StateException
     */
    public function inProgress(): void
    {
        throw new StateException();
    }

    /**
     * @throws StateException
     */
    public function postponed(): void
    {
        throw new StateException();
    }

    /**
     * @throws StateException
     */
    public function estimation(): void
    {
        throw new StateException();
    }

    /**
     * @throws StateException
     */
    public function done(): void
    {
        throw new StateException();
    }

    /**
     * @throws StateException
     */
    public function closed(): void
    {
        throw new StateException();
    }
}
