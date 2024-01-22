<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function mentionedUsers()
{
    preg_match_all('/@(\w+)/', $this->content, $matches);

    return $matches[1] ?? [];
}

}
