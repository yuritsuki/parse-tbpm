<?php

namespace App\Document;

use App\DB;
use App\Document\Document;

class OutgoingDocument extends Document
{

    public static function cardId(): string
    {
        return 60;
    }

    public static function cardTableName(): string
    {
        return 'Card_C_0060';
    }

    public static function typeSlug(): string
    {
        return 'outgoing_document';
    }

    public function getSecondaryDocumentType(): ?array {
        return $this->getEsedoDocumentType();
    }

    public function getLanguage(): ?string {
        return $this->getEsedoLanguage();
    }


    public function getDocumentCharacter(): ?array
    {
        $record = DB::table('Card_D_0162')->where('itemid', $this->getCard()->esedoquestion)->first();
        return $record ? [
            'ru' => $record->name_ru,
            'kk' => $record->name_kz,
        ] : null;
    }

    public function getReplyDocumentId(): ?int
    {
        return $this->getCard()->answeroninboxdocument;
    }
}
