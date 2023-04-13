<?php

namespace Alura\PDO\Domain\Model;

require_once 'vendor/autoload.php';

class Phone
{
    private ?int $id;
    private string $areaCode;
    private string $number;

    public function __construct(?int $id, string $areaCode, string $number)
    {

        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }

    public function __toString(): string
    {
        return "({$this->areaCode}) {$this->number}";
    }
}