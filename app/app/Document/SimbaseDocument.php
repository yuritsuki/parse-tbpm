<?php

namespace App\Document;

interface SimbaseDocument
{
    public static function documentTypeId(): int;
    public static function completedStatusId(): int; // look statuses in OBJ_VAL_WORKFLOW and OBJECTS.I_STATE

    public static function usersTableRoleFields(): array;

    public function getDocumentType(): string;
    public function getId(): int;
    public function getDeadline(): ?string;
    public function getRegisteredToPoolAt(): ?string;
    public function getCreatedAt(): ?string;
    public function getDescription(): ?string;
    public function getShortDescription(): ?string;
    public function getPoolIndex(): ?string;
    public function getOutgoingPoolIndex(): ?string;
    public function getAuthor(): ?object;
    public function getLastExecutor(): ?object;
    public function getAttachments(): array;
    public function getLanguage(): ?string;
    public function getDeliveryWay(): ?string;
    public function getControlType(): ?string;
    public function getSecondaryDocumentType(): ?string;
    public function getCompany(): ?string;
    public function getCorrespondenceName(): ?string;
    public function getOutgoingDate(): ?string;
    public function getDocumentUsers(): array;
    public function getDocumentCharacter(): ?string;
    public function getNomenclature(): ?string;
    public function getRegistrator(): ?object;
    public function getSigner(): ?object;
    public function getAppealedBy(): ?string;
    public function getAgenda(): ?string;
    public function getProtocolDate(): ?string;
    public function getProtocolPlace(): ?string;

    public function getParticipants(): array;

    public function getSecretary(): ?object;

}
