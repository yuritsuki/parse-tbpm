<?php

namespace App\Commands;

use App\ArchiveDocument\ArchiveDocument;
use App\ArchiveDocument\ArchiveDocumentAttachment;
use App\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class ImportTengriFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-tengri-files';

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
        $documentIds = ArchiveDocument::where('source', 'tengri')
            ->whereDoesntHave('attachments')
            ->orderBy('id','asc')
            ->pluck('id')->toArray();

        $bar = $this->output->createProgressBar(count($documentIds));


        foreach($documentIds as $documentId) {
            $bar->advance();

            $document = ArchiveDocument::find($documentId);
            $tempAttachments = json_decode($document->temp_attachments,true);

            if (!$tempAttachments || !is_array($tempAttachments) || count($tempAttachments) === 0) {
                continue;
            }
            foreach ($tempAttachments as $index => $attachment) {
                $uuid = (string) Str::uuid();
                $uploadedName = $attachment['name'];


                $fileRecord = DB::table('Files')->where('attachedfileid',$attachment['id'])->first();
                if($fileRecord) {
                    $extension = pathinfo($uploadedName, PATHINFO_EXTENSION);
                    $newName = $uuid . '.' . $extension;
                    $localPath = storage_path("app/public/archive_documents/$newName");
                    file_put_contents($localPath, $fileRecord->content);
                    ArchiveDocumentAttachment::create([
                        'archive_document_id'    => $documentId,
                        'doc_file_type'          => $index === 0 ? 'MAIN_DOC' : 'ATTACHMENT',
                        'original_document_name' => $uploadedName,
                        'original_document_path' => "archive_documents/$newName",
                    ]);
                }

            }
        }
        $bar->finish();


    }
}
