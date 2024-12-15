<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = "tasks";

    protected $primaryKey = "id";

    protected $keyType = 'string';


    use HasUuids;

    protected $fillable = [
        'label',
        'description',
        'date',
        'status',
    ];

    // const CREATED_AT = 'created';
    // const UPDATED_AT = 'updated';

}
