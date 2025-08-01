<?php

namespace App;

class DB extends \Illuminate\Support\Facades\DB
{

    public static function table(string $table): \Illuminate\Database\Query\Builder
    {
        return parent::table("dbo.".$table);
    }
}
