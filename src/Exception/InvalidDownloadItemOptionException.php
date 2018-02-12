<?php

declare(strict_types=1);

namespace App\Exception;

class InvalidDownloadItemOptionException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Nie istnieje żądana opcja dla pobrania listy produktów');
    }
}
