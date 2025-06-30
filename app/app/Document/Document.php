<?php

namespace App\Document;

use App\Document\Traits\Simbase;

abstract class Document implements SimbaseDocument
{
    use Simbase;

    protected object $document;
    public function __construct(object $record)
    {
        $this->document = $record;
    }

    public static function fromData(object $data): static {
        return new static($data);
    }

    public function getId(): int
    {
        return $this->document->I_ID;
    }

    public function getName(): string
    {
        return $this->document->S_NAME;
    }

    public function toArray(): array
    {
        $author = $this->getAuthor();
        $lastExecutor = $this->getLastExecutor();
        $signer = $this->getSigner();
        $registrator = $this->getRegistrator();
        $secretary = $this->getSecretary();
        return [
            'id' => $this->getId(),
            'type' => $this->getDocumentType(),
            'name' => $this->getName(),
            'deadline' => $this->getDeadline(),
            'registered_to_pool_at' => $this->getRegisteredToPoolAt(),
            'created_at' => $this->getCreatedAt(),
            'description' => $this->getDescription(),
            'short_description' => $this->getShortDescription(),
            'pool_index' => $this->getPoolIndex(),
            'outgoing_pool_index' => $this->getOutgoingPoolIndex(),
            'author' => $author ? $this->username($author) : null,
            'last_executor' => $lastExecutor ? $this->username($lastExecutor) : null,
            'attachments' => json_encode($this->getAttachments()),
            'language' => $this->getLanguage(),
            'delivery_way' => $this->getDeliveryWay(),
            'control_type' => $this->getControlType(),
            'secondary_document_type' => $this->getSecondaryDocumentType(),
            'company' => $this->getCompany(),
            'correspondence_name' => $this->getCorrespondenceName(),
            'outgoing_date' => $this->getOutgoingDate(),
            ...array_map(
                fn($x) => implode(', ', array_map(fn($y) => $this->username($y), $x)),
                $this->getDocumentUsers()
            ),
            'character' => $this->getDocumentCharacter(),
            'nomenclature' => $this->getNomenclature(),
            'registrator' => $registrator ? $this->username($registrator) : null,
            'signer' => $signer ? $this->username($signer) : null,
            'appealed_by' => $this->getAppealedBy(),
            'agenda' => $this->getAgenda(),
            'protocol_date' => $this->getProtocolDate(),
            'protocol_place' => $this->getProtocolPlace(),
            'participants' => implode(', ',array_map(
                fn($x) => $this->username($x),
                $this->getParticipants()
            )),
            'secretary' => $secretary ? $this->username($secretary) : null,
        ];
    }



}
