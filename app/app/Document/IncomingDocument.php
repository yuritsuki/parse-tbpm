<?php

namespace App\Document;

use App\Document\Traits\Simbase;
use Carbon\Carbon;

class IncomingDocument extends Document
{
    use Simbase;
    public static function documentTypeId(): int
    {
        return 23;
    }

    public static function completedStatusId(): int
    {
        return 261;
    }

    public static function usersTableRoleFields(): array
    {
        return [
            'recipients' => 1043
        ];
    }

    public function getDocumentType(): string
    {
        return 'incoming';
    }

    public function getDeadline(): ?string
    {
        return $this->parseDate($this->document->I_DATE_END_DATE);
    }

    public function getRegisteredToPoolAt(): ?string
    {
        return $this->parseDate($this->document->I_DATE_START_DATE)." ".$this->parseTime($this->document->I_DATE_START_TIME);
    }

    public function getCreatedAt(): ?string
    {
        return Carbon::parse($this->document->I_UTC_CREATED)->addHours(6)->toDateString();
    }

    public function getShortDescription(): ?string
    {
        return $this->queryFieldText($this->getId(),966);
    }
    public function getDescription(): ?string
    {
        return $this->queryFieldTextLong($this->getId(),2761);
    }

    public function getPoolIndex(): ?string
    {
        return $this->queryFieldText($this->getId(),997);
    }

    public function getOutgoingPoolIndex(): ?string
    {
        return $this->queryFieldText($this->getId(),991);
    }

    public function getAuthor(): ?object
    {
        return $this->queryFieldUser($this->getId(),959);
    }

    public function getLastExecutor(): ?object
    {
        return $this->queryFieldUser($this->getId(),965);
    }

    public function getAttachments(): array
    {
        return $this->queryAttachments($this->getId());
    }

    public function getLanguage(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),1014);
    }

    public function getDeliveryWay(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),1020);
    }

    public function getControlType(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),1023);
    }

    public function getSecondaryDocumentType(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),2733);
    }

    public function getCompany(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3052);
    }

    public function getCorrespondenceName(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),3145);
    }

    public function getOutgoingDate(): ?string
    {
        return $this->parseDate($this->document->I_DATE_START_DATE);
    }

    public function getDocumentUsers(): array
    {
        echo "hello\n";
//        echo json_encode($this->queryDocumentUsers($this->getId(),980));
        return $this->queryDocumentUsers($this->getId(),980);
    }

    public function getDocumentCharacter(): ?string
    {
        return $this->queryDictionaryValue($this->getId(),2755);
    }


    public function getNomenclature(): ?string
    {
        return null;
    }

    public function getRegistrator(): ?object
    {
        return $this->getAuthor();
    }

    public function getSigner(): ?object
    {
        return null;
    }

    public function getAppealedBy(): ?string
    {
        $phys = $this->queryFieldText($this->getId(),2315);
        $jur = $this->queryFieldText($this->getId(),2314);
        return $phys.$jur;
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
