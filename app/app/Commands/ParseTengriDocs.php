<?php

namespace App\Commands;

use App\DB;
use App\Document\Factories\DocumentFactory;
use App\Document\IncomingDocument;
use App\Document\InternalDocument;
use App\Document\OutgoingDocument;
use App\Document\Protocol;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class ParseTengriDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    public function handle()
    {

        // пример входа 1369560
        // пример исхода 1372719
        // пример внутр 1376068
        // пример протокола 1339143
        $query = DB::table('Item')
            ->where(function($q) {
                $q->where(function($q2) {
                    $q2->where('cardid',IncomingDocument::cardId())
                        ->where('cardstateid',IncomingDocument::completedStateId());
                })->orWhere(function ($q2) {
                    $q2->where('cardid',OutgoingDocument::cardId())
                        ->where('cardstateid',OutgoingDocument::completedStateId());
                })->orWhere(function ($q2) {
                    $q2->where('cardid',InternalDocument::cardId())
                        ->where('cardstateid',InternalDocument::completedStateId());
                })->orWhere(function($q2) {
                    $q2->where('cardid',Protocol::cardId())
                        ->where('cardstateid',Protocol::completedStateId());
                });
            })->leftJoin(
            'dbo.Item_Document',
            'dbo.Item.id',
            '=',
            'dbo.Item_Document.baseitemid'
            )->selectRaw('dbo.Item.*, dbo.Item_Document.cardstateid')
            ->where('isdeleted',0)->orderByDesc('id');

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
