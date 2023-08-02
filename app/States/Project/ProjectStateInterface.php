<?php
declare(strict_types=1);

namespace App\States\Project;

interface ProjectStateInterface
{
    public function open(): void;
    public function inProgress(): void;
    public function postponed(): void;
    public function estimation(): void;
    public function done(): void;
    public function closed(): void;
}
