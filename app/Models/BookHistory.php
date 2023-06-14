<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Book history model
 *
 * @author Putra <putrarohayzad>
 */
class BookHistory extends Model
{
    use HasFactory;

    /**
     * Get the book that owns the book history.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
