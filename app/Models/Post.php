<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Post extends Model
{
    public static function make(string $markdownContent, string $htmlContent, User $user): self
    {
        $instance = new self;
        $instance->attributes['markdown_content'] = $markdownContent;
        $instance->attributes['html_content'] = $htmlContent;
        $instance->user()->associate($user);

        return $instance;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
