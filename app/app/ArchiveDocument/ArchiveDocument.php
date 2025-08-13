<?php

namespace App\ArchiveDocument;

use Illuminate\Database\Eloquent\Model;

class ArchiveDocument extends Model
{
    protected $connection = 'pgsql';

    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ArchiveDocumentAttachment::class);
    }

}
