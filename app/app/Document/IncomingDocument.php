<?php

namespace App\Document;

use App\DB;

class IncomingDocument extends Document
{

    public static function cardId(): string
    {
        return 1;
    }

    public static function cardTableName(): string
    {
        return "Card_C_0001";
    }

    public static function typeSlug(): string
    {
        return "incoming_document";
    }

    public function getSecondaryDocumentType(): ?array {
        return $this->getEsedoDocumentType();
    }

    public function getLanguage(): ?string {
        return $this->getEsedoLanguage();
    }

    public function getSentFromEsedoAt(): ?string {
        return $this->getCard()->esedosenddate;
    }

    public function getOutgoingPoolIndex(): ?string {
        return $this->getCard()->outnumber;
    }

    public function getCorrespondenceName(): ?string {
        return DB::table('Contragent')->where('itemid',$this->getCard()->correspondent)->first()->name ?? null;
    }
}
