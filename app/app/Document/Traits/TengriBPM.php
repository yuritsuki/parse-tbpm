<?php

namespace App\Document\Traits;

use App\DB;

trait TengriBPM
{

    public function getItemDocument(): object {
        return DB::table('Item_Document')->where('baseitemid', $this->getId())->first();
    }

    public function getCard(): object {
        return DB::table($this->cardTableName())->where('itemid', $this->getId())->first();
    }

    public function getEmployee($id): string
    {
        $record = DB::table('Employees')->where('id',$id)->first();
        return $record->title;
    }

    public function getEsedoDocumentType(): ?array
    {
        $record =  DB::table('Card_D_0159')->where('itemid',$this->getCard()->esedodocumenttype)->first();
        return $record ? [
            'ru' => $record->name_ru,
            'kk' => $record->name_kz,
        ] : null;
    }

    public function getTasks(): \Illuminate\Support\Collection
    {
        return DB::table('Item_Task')->where('relateditemid', $this->getId())->get();
    }

    public function getAssignedUsers($cardId): string
    {
        if(!is_array($cardId)) {
            $cardId = [$cardId];
        }
        $tasks = $this->getTasks()->whereIn('basecardid', $cardId);
        $users = [];
        $tasks->each(function($task) use (&$users) {
            $users[] = $this->getEmployee($task->assignedto);
        });
        return implode(', ', $users);
    }

    public function getEsedoLanguage(): ?string {
        return DB::table('Card_D_0160')->where('itemid',$this->getCard()->esedolanguage)->first()->title ?? null;
    }

}
