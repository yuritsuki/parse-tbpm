<?php

namespace App\Document\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


trait Simbase
{

    /**
     * Parse int date to str date
     * @param int $val
     * @return string
     */
    private function parseDate(int $val): string
    {
        return Carbon::parse('1970-01-01')->setTime(0,0)->addDays($val)->toDateString();
    }


    /**
     * Parse int time to str time
     * @param int $val
     * @return string
     */
    private function parseTime(int $val): string
    {
        return gmdate('H:i:s', $val + (6 * 3600));
    }


    /**
     * Get longtext type value
     *
     * @param int $id
     * @param int $field
     * @return string|null
     */
    private function queryFieldTextLong(int $id, int $field): ?string
    {
        $record = DB::table('OBJ_VAL_TEXT_LONG')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$field)->first();
        if($record) {
            return $record->S_VAL;
        }
        return null;
    }

    /**
     * Get text type value
     *
     * @param int $id
     * @param int $field
     * @return string|null
     */
    private function queryFieldText(int $id, int $field): ?string
    {
        $record = DB::table('OBJ_VAL_TEXT')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$field)->first();
        if($record) {
            return $record->S_VAL;
        }
        return null;
    }


    /**
     * Get document user
     *
     * @param int $id
     * @param int $field
     * @return object|null
     */
    private function queryFieldUser(int $id, int $field): ?object
    {
        $fieldRecord = DB::table('OBJ_VAL_USER')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$field)->first();
        if($fieldRecord) {
            $userId = $fieldRecord->I_VAL;
            if($userId) {
                return $this->getUser($userId);
            }
        }
        return null;
    }

    /**
     * Get document users
     * @param int $id
     * @param int $field
     * @return array
     */
    private function queryFieldUsers(int $id, int $field): array
    {
        $array = [];
        $records =  DB::table('OBJ_VAL_USERS')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$field)->get();
        foreach($records as $record) {
            $userId = $record->I_VAL;
            if($userId) {
                $array[] = $this->getUser($userId);
            }
        }
        return $array;
    }

    /**
     * Get user full name
     *
     * @param object $user
     * @return string
     */
    private function username(object $user): string
    {
        return $user->S_LASTNAME." ".$user->S_FIRSTNAME;
    }

    /**
     * Get user by id
     *
     * @param $userId
     * @return object|null
     */
    private function getUser($userId) {
        return DB::table('USERS')->where('I_ID','=',$userId)->first();
    }

    /**
     * Get document attachments
     * @param int $id
     * @return array
     */
    private function queryAttachments(int $id): array
    {
        $attachments = DB::table('OBJ_FILES')->where('I_OBJ','=',$id)->get()->toArray();
        return array_map(function($attachment) {
            return [
                'uploaded_name' => $attachment->S_NAME,
                'uploaded_path' => $attachment->S_NAME_ON_DISK,
                'printable_path' => $attachment->S_NAME_ON_DISK_AS_PDF,
            ];
        }, $attachments);

    }

    /**
     * Get dictionary value
     *
     * @param int $id
     * @param int $fieldId
     * @param array $values
     *
     * @return string|null
     */

    private function queryDictionaryValue(int $id, int $fieldId, array $values = [0]): ?string
    {
        $fieldValue = DB::table('OBJ_VAL_DICT_USER')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$fieldId)->first();
        if($fieldValue) {
            $labels = DB::table('LABELS_USER')->where('I_LANG',570)->where('I_SET','=',$fieldValue->I_VAL)->get();
            $result = '';
            foreach($labels as $key => $label) {
                if(in_array($key, $values)) {
                    if($result) $result .= ' ';
                    $result .= $label->S_LABEL;
                }
            }
            return $result;
        }
        return null;
    }

    /**
     * Returns users of documents (by role)
     *
     * @param int $id
     * @param int $tableId
     * @return array
     */
    private function queryDocumentUsers(int $id, int $tableId): array
    {
        $array = [];
        $records = DB::table('OBJ_VAL_TABLE_USER')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$tableId)->get();
        foreach($records as $record) {
            foreach($this->usersTableRoleFields() as $key => $field) {
                if($record->I_COL === $field) {
                    if(!isset($array[$key])) {
                        $array[$key] = [];
                    }
                    $array[$key][] = $this->getUser($record->I_VAL);
                }
            }
        }
        return $array;
    }

    /**
     * Get date value
     *
     * @param int $id
     * @param int $field
     * @return string|null
     */

    public function queryFieldDate(int $id, int $field): ?string
    {
        $record = DB::table('OBJ_VAL_DATE')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$field)->first();
        if($record) {
            return $this->parseDate($record->I_VAL);
        }
        return null;
    }

    /**
     * Get time value
     *
     * @param int $id
     * @param int $field
     * @return string|null
     */

    public function queryFieldTime(int $id, int $field): ?string
    {
        $record = DB::table('OBJ_VAL_TIME')->where('I_OBJ','=',$id)
            ->where('I_BPF','=',$field)->first();
        if($record) {
            return $this->parseTime($record->I_VAL);
        }
        return null;
    }
}
