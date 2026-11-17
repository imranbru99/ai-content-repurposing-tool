<?php

namespace App\Enums;

enum DraftStatus: string
{
    case Idea = 'idea';
    case Draft = 'draft';
    case Review = 'review';
    case Scheduled = 'scheduled';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Idea => 'Idea',
            self::Draft => 'Draft',
            self::Review => 'In Review',
            self::Scheduled => 'Scheduled',
            self::Published => 'Published',
            self::Archived => 'Archived',
        };
    }
}