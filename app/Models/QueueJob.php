<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueueJob extends Model
{
    protected $table = 'jobs';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'available_at' => 'integer',
            'created_at' => 'integer',
        ];
    }
}
