<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StateException extends Exception
{
    public function __construct(string $message = "Entity can't accept this state.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
