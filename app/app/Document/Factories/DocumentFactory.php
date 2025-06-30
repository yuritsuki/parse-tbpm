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
        return match($data->I_PROCESS ?? null) {
            14 => InternalDocument::fromData($data),
            23 => IncomingDocument::fromData($data),
            27 => OutgoingDocument::fromData($data),
            36 => Protocol::fromData($data),
            default => throw new InvalidArgumentException("Unknown I_PROCESS: {$data->I_PROCESS}")
        };
    }

}
