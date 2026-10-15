<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryAttendance extends Model
{
    use HasFactory;

    // Add the columns that are allowed to be saved via create() or update()
    protected $fillable = [
        'user_id',
        'entry_time',
        'exit_time'
    ];

    /**
     * Relationship back to the User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}