<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListItem extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    // How long the user has to undo a delete before it is purged.
    public const UNDO_SECONDS = 6;

    protected $fillable = ['name', 'is_complete'];

    public function prunable()
    {
        return static::onlyTrashed()
            ->where('deleted_at', '<=', now()->subSeconds(self::UNDO_SECONDS));
    }
}
