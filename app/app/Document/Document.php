<?php

namespace App\Document;

use App\DB;
use App\Document\Traits\TengriBPM;
use http\Encoding\Stream\Inflate;

abstract class Document
{

    use TengriBPM;

    protected object $document;

    public function __construct($data)
    {
        $this->document = $data;
    }

    public static function fromData(object $data): static {
        return new static($data);
    }

    // =================================================================================================================
    // CONCRETE DOCUMENT TYPE SETTINGS
    // =================================================================================================================

    abstract public static function cardId(): string;

    abstract public static function cardTableName(): string;

    abstract public static function typeSlug(): string;

    public static function completedStateId(): int
    {
        return 7;
    }

    // =================================================================================================================
    // GETTERS
    // =================================================================================================================

    public function getId(): int {
        return $this->document->id;
    }
    public function getPoolIndex(): string {
        return $this->getItemDocument()->f_regnumber;
    }

    public function getRegisteredToPoolAt(): ?string {
        return $this->getItemDocument()->regdate;
    }

    public function getSecondaryDocumentType(): ?array {
        return null;
    }

    public function getRegistrator(): ?string {
        $registratorId = $this->getItemDocument()->registratorid;
        return $registratorId ? $this->getEmployee($registratorId) : null;
    }

    public function getLanguage(): ?string {
        return null;
    }

    public function getShortDescription(): string {
        return $this->getCard()->subject;
    }

    public function getNote(): ?string {
        return $this->getCard()->comment;
    }

    public function getSentFromEsedoAt(): ?string {
        return null;
    }

    public function getOutgoingPoolIndex(): ?string {
        return null;
    }

    public function getCorrespondenceName(): ?string {
        return null;
    }

    public function getAuthorName(): string {
        return $this->getEmployee($this->document->authorid);
    }

    public function getRecipients(): string
    {
        return $this->getAssignedUsers(136);
    }

    public function getExecutors(): string
    {
        return $this->getAssignedUsers(52);
    }

    public function getAttachments(): array
    {
        return DB::table('AttachedFiles')->where('itemid',$this->getId())->get()->map(function($x) {
            return [
                'id' => $x->id,
                'name' => $x->name,
            ];
        })->toArray();
    }

    public function getCreatedAt(): string {
        return $this->document->created;
    }

    public function getDocumentCharacter(): ?array {
        return null;
    }

    public function getReplyDocumentId(): ?int {
        return null;
    }

    public function getReviewers(): string {
        return $this->getAssignedUsers(39);
    }

    public function getSigners(): string
    {
        return $this->getAssignedUsers([188,40]);
    }

    public function getDate(): ?string
    {
        return null;
    }

    public function getSecretaryName(): ?string
    {
        return null;
    }

    public function getVisitedParticipators(): ?string
    {
        return null;
    }


    public function toArray(): array {
        $secondaryDocumentType = $this->getSecondaryDocumentType();
        $documentCharacter = $this->getDocumentCharacter();
        return [
            'id' => $this->getId(),
            'type' => static::typeSlug(),
            'pool_index' => $this->getPoolIndex(),
            'registered_to_pool_at' => $this->getRegisteredToPoolAt(),
            'secondary_document_type' => $secondaryDocumentType['ru'] ?? null,
            'registrator' => $this->getRegistrator(),
            'language' => $this->getLanguage(),
            'short_description' => $this->getShortDescription(),
            'note' => $this->getNote(),
            'sent_from_esedo_at' => $this->getSentFromEsedoAt(),
            'outgoing_pool_index' => $this->getOutgoingPoolIndex(),
            'correspondence_name' => $this->getCorrespondenceName(),
            'author_name' => $this->getAuthorName(),
            'recipients' => $this->getRecipients(),
            'executors' => $this->getExecutors(),
            'attachments' => json_encode($this->getAttachments()),
            'created_at' => $this->getCreatedAt(),
            'document_character' => $documentCharacter['ru'] ?? null,
            'reply_document_id' => $this->getReplyDocumentId(),
            'reviewers' => $this->getReviewers(),
            'signers' => $this->getSigners(),
            'date' => $this->getDate(),
            'secretary' => $this->getSecretaryName(),
            'visited_participators' => $this->getVisitedParticipators(),
        ];
    }


}
