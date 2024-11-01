<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'roles';
    protected $guarded = [];
    protected $timestamp = true;

    public function createdBy() : BelongsTo{
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
