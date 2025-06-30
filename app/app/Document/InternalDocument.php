<?php

namespace App\Document;

use App\Document\Traits\Simbase;
use Carbon\Carbon;

class InternalDocument extends Document
{

    use Simbase;
    public static function documentTypeId(): int
    {
        return 14;
    }

    public static function completedStatusId(): int
    {
        return 170;
    }

    public function getDocumentType(): string
    {
        return 'internal';
    }

    public function getDeadline(): ?string
    {
        return null;
    }

    public function getRegisteredToPoolAt(): ?string
    {
        return $this->queryFieldDate($this->getId(),430);
    }

    public function getCreatedAt(): ?string
    {
        return Carbon::parse($this->document->I_UTC_CREATED)->addHours(6)->toDateString();
    }

    public function getShortDescription(): ?string
    {
        return $this->queryFieldText($this->getId(),399);
    }
    public function getDescription(): ?string
    {
        return null;
    }

    public function getPoolIndex(): ?string
    {
        return $this->queryFieldText($this->getId(),405);
    }

    public function getOutgoingPoolIndex(): ?string
    {
        return null;
    }

    public function getAuthor(): ?object
    {
        return $this->queryFieldUser($this->getId(),403);
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
        return $this->queryDictionaryValue($this->getId(),409);
    }

    public function getDeliveryWay(): ?string
    {
        return null;
    }

    public function getControlType(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),2847);
    }

    public function getSecondaryDocumentType(): ?string
    {
        return null;
    }

    public function getCompany(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3073);
    }

    public function getCorrespondenceName(): ?string
    {
        return null;
    }

    public function getOutgoingDate(): ?string
    {
        return null;
    }

    public function getDocumentUsers(): array
    {
        return [
            ...$this->queryDocumentUsers($this->getId(),426),
            ...$this->queryDocumentUsers($this->getId(),457),
        ];
    }

    public static function usersTableRoleFields(): array
    {
        return [
            'reviewers' => 459,
            'recipients' => 460
        ];
    }

    public function getDocumentCharacter(): ?string
    {
        return null;
    }

    public function getNomenclature(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3072, [1,2]);
    }

    public function getRegistrator(): ?object
    {
        return null;
    }

    public function getSigner(): ?object
    {
        return $this->queryFieldUser($this->getId(),429);
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
