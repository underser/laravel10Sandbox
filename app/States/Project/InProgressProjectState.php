<?php
declare(strict_types=1);

namespace App\States\Project;

class InProgressProjectState extends BaseProjectState
{
    public function postponed(): void
    {
        parent::postpone(); // TODO: Change the autogenerated stub
    }

    public function estimation(): void
    {
        parent::estimate(); // TODO: Change the autogenerated stub
    }

    public function done(): void
    {
        parent::done(); // TODO: Change the autogenerated stub
    }
}
