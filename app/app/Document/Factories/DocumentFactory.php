<?php

namespace App\Document\Factories;

use App\Document\Document;
use App\Document\IncomingDocument;
use App\Document\InternalDocument;
use App\Document\OutgoingDocument;
use App\Document\Protocol;
use InvalidArgumentException;

class DocumentFactory
{
    public static function fromData(object $data): Document
    {
        return match($data->cardid ?? null) {
            IncomingDocument::cardId() => IncomingDocument::fromData($data),
            OutgoingDocument::cardId() => OutgoingDocument::fromData($data),
            InternalDocument::cardId() => InternalDocument::fromData($data),
            Protocol::cardId() => Protocol::fromData($data),
            default => throw new InvalidArgumentException("Unknown Card ID: {$data->cardid}")
        };
    }

}
