<?php
namespace App\Services\Interfaces;

interface ClientServiceFactory
{
    public function setDetails(Object $request): self;
    public function getDetails(): array;
    public function generatedExternalId():int;
}
