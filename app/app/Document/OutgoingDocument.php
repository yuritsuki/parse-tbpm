<?php

namespace App\Document;

use App\Document\Traits\Simbase;
use Carbon\Carbon;

class OutgoingDocument extends Document
{

    use Simbase;
    public static function documentTypeId(): int
    {
        return 27;
    }

    public static function completedStatusId(): int
    {
        return 322;
    }

    public function getDocumentType(): string
    {
        return 'outgoing';
    }

    public function getDeadline(): ?string
    {
        return null;
    }

    public function getRegisteredToPoolAt(): ?string
    {
        return $this->queryFieldDate($this->getId(),1467)." ".$this->queryFieldTime($this->getId(),3298);
    }

    public function getCreatedAt(): ?string
    {
        return Carbon::parse($this->document->I_UTC_CREATED)->addHours(6)->toDateString();
    }

    public function getShortDescription(): ?string
    {
        return $this->queryFieldText($this->getId(),1433);
    }
    public function getDescription(): ?string
    {
        return null;
    }

    public function getPoolIndex(): ?string
    {
        return $this->queryFieldText($this->getId(),1464);
    }

    public function getOutgoingPoolIndex(): ?string
    {
        return null;
    }

    public function getAuthor(): ?object
    {
        return $this->queryFieldUser($this->getId(),1418);
    }

    public function getLastExecutor(): ?object
    {
        return null;
    }

    public function getAttachments(): array
    {
        return $this->queryAttachments($this->getId());
    }

    public function getLanguage(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),1507);
    }

    public function getDeliveryWay(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3163);
    }

    public function getControlType(): ?string
    {
        return null;
    }

    public function getSecondaryDocumentType(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),2756);
    }

    public function getCompany(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3054);
    }

    public function getCorrespondenceName(): ?string
    {
        return $this->queryFieldText($this->getId(),1438);
    }

    public function getOutgoingDate(): ?string
    {
        return null;
    }

    public function getDocumentUsers(): array
    {
        return $this->queryDocumentUsers($this->getId(),1473);
    }

    public static function usersTableRoleFields(): array
    {
        return [
            'reviewers' => 1542
        ];
    }

    public function getDocumentCharacter(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),1485);
    }

    public function getNomenclature(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3075, [1,2]);
    }

    public function getRegistrator(): ?object
    {
        return $this->queryFieldUser($this->getId(),1469);
    }

    public function getSigner(): ?object
    {
        return $this->queryFieldUser($this->getId(),1416);
    }

    public function getAppealedBy(): ?string
    {
        return null;
    }

    public function getAgenda(): ?string
    {
        return null;
    }

    public function getProtocolDate(): ?string
    {
        return null;
    }

    public function getProtocolPlace(): ?string
    {
        return null;
    }

    public function getParticipants(): array
    {
        return [];
    }

    public function getSecretary(): ?object
    {
        return null;
    }
}
