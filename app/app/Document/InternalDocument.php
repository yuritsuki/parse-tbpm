<?php

namespace App\Document;

use App\DB;
use App\Document\Document;

class InternalDocument extends Document
{

    public static function cardId(): string
    {
        return 73;
    }

    public static function cardTableName(): string
    {
        return 'Card_C_0073';
    }

    public static function typeSlug(): string
    {
        return 'internal_document';
    }

    public function getLanguage(): ?string
    {
        $languageRecord = DB::table(self::cardTableName().'_Language')->where('carditemid', $this->getId())->first();
        if($languageRecord) {
            return DB::table('Card_D_0007')->where('itemid',$languageRecord->languageid)->first()->title;
        } else {
            return null;
        }
    }
}
