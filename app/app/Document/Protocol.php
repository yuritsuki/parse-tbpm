<?php

namespace App\Document;

use App\DB;
use App\Document\Document;

class Protocol extends Document
{

    public static function cardId(): string
    {
        return 143;
    }

    public static function cardTableName(): string
    {
        return 'Card_C_0143';
    }

    public static function typeSlug(): string
    {
        return 'protocol';
    }

    public function getSecondaryDocumentType(): ?array {
        $record =  DB::table('Card_D_0246')->where('itemid',$this->getCard()->documenttype)->first();
        return $record ? [
            'ru' => $record->title
        ] : null;
    }

    public function getDate(): ?string
    {
        return $this->getCard()->zaseddate;
    }

    public function getSecretaryName(): ?string
    {
        $id = $this->getCard()->executor;
        return $id ? $this->getEmployee($id) : null;
    }

    public function getVisitedParticipators(): ?string
    {
        $attendees = DB::table(self::cardTableName().'_Attended')->where('carditemid',$this->getId())->get();
        $users = [];
        $attendees->each(function($attendee) use (&$users) {
            $users[] = $this->getEmployee($attendee->attendedid);
        });
        return implode(', ', $users);
    }
}
