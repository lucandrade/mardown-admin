<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    public static function make(string $markdownContent, string $htmlContent, User $user): self
    {
        $instance = new self;
        $instance->updateContent($markdownContent, $htmlContent);
        $instance->user()->associate($user);

        return $instance;
    }

    public function updateContent(string $markdownContent, string $htmlContent): void
    {
        $this->attributes['markdown_content'] = $markdownContent;
        $this->attributes['html_content'] = $htmlContent;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
