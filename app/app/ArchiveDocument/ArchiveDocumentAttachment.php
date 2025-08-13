<?php

namespace App\ArchiveDocument;

use Illuminate\Database\Eloquent\Model;

class ArchiveDocumentAttachment extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'archive_document_id',
        'doc_file_type',
        'original_document_name',
        'original_document_path',
    ];
}
