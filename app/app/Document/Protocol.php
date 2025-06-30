<?php

namespace App\Document;

use App\Document\Traits\Simbase;
use Carbon\Carbon;

class Protocol extends Document
{

    use Simbase;
    public static function documentTypeId(): int
    {
        return 36;
    }

    public static function completedStatusId(): int
    {
        return 417;
    }

    public function getDocumentType(): string
    {
        return 'protocol';
    }

    public function getDeadline(): ?string
    {
        return null;
    }

    public function getRegisteredToPoolAt(): ?string
    {
        return $this->parseDate($this->document->I_DATE_START_DATE);
    }

    public function getCreatedAt(): ?string
    {
        return Carbon::parse($this->document->I_UTC_CREATED)->addHours(6)->toDateString();
    }

    public function getShortDescription(): ?string
    {
        return null;
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
        return null;
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
        return $this->queryDictionaryValue($this->getId(),2503);
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
            ...$this->queryDocumentUsers($this->getId(),2380),
            ...$this->queryDocumentUsers($this->getId(),2410),
        ];
    }

    public static function usersTableRoleFields(): array
    {
        return [
            'reviewers' => 2413,
            'executors' => 2425,
        ];
    }

    public function getDocumentCharacter(): ?string
    {
        return null;
    }

    public function getNomenclature(): ?string
    {
        return null;
    }

    public function getRegistrator(): ?object
    {
        return null;
    }

    public function getSigner(): ?object
    {
        return $this->queryFieldUser($this->getId(),2381);
    }

    public function getAppealedBy(): ?string
    {
        return null;
    }

    public function getAgenda(): ?string
    {
        return $this->queryFieldText($this->getId(),2339);
    }

    public function getProtocolDate(): ?string
    {
        return $this->queryFieldDate($this->getId(),2510);
    }

    public function getProtocolPlace(): ?string
    {
        return $this->queryFieldText($this->getId(),2504);
    }

    public function getParticipants(): array
    {
       return $this->queryFieldUsers($this->getId(),2505);
    }

    public function getSecretary(): ?object
    {
        return $this->queryFieldUser($this->getId(),2357);
    }
}
