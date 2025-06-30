<?php

namespace App\Commands;

use App\Document\Factories\DocumentFactory;
use App\Document\IncomingDocument;
use App\Document\InternalDocument;
use App\Document\OutgoingDocument;
use App\Document\Protocol;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class ParseSimbaseDocs extends Command
{
    /*
     * TODO:
     * -other doc types
     * -convert attachments
     */
    protected $signature = 'simbase:test';

    protected $description = 'Архив SimBASE';

    /**
     * Run the script
     *
     * @return void
     */
    public function handle(): void
    {

        $query = DB::table('OBJECTS')
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('I_PROCESS',IncomingDocument::documentTypeId())->where('I_STATE',IncomingDocument::completedStatusId());
                })->orWhere(function($q) {
                    $q->where('I_PROCESS',OutgoingDocument::documentTypeId())->where('I_STATE',OutgoingDocument::completedStatusId());
                })->orWhere(function($q) {
                    $q->where('I_PROCESS',InternalDocument::documentTypeId())->where('I_STATE',InternalDocument::completedStatusId());
                })->orWHere(function($q) {
                    $q->where('I_PROCESS',Protocol::documentTypeId())->where('I_STATE',Protocol::completedStatusId());
                });
            })->orderBy('I_ID','DESC');

        $count = $query->clone()->count();
        $this->output->progressStart($count);
        // get documents
        $query->clone()->chunk(1000, function($documents) {
                $documents->toArray();
                foreach ($documents as $document) {
                    $document = DocumentFactory::fromData($document)->toArray();
                    $filename = 'json/' . $document['id'] . '.json';
                    $jsonContent = json_encode($document, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    Storage::put($filename, $jsonContent);
                    $this->output->progressAdvance();
                }
            });
        $this->output->progressFinish();

    }



}
