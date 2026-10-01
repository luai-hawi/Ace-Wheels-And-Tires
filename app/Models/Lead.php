<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A submission from the site's Contact / Request Service form. */
class Lead extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_interested',
        'message',
        'source_url',
        'status',
    ];
}
