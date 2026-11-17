<?php

namespace App\Enums;

enum SourceType: string
{
    case Webinar = 'webinar';
    case Blog = 'blog';
    case Podcast = 'podcast';
    case Video = 'video';
    case Whitepaper = 'whitepaper';
    case Transcript = 'transcript';

    public function label(): string
    {
        return config("repurpose.source_types.{$this->value}", $this->value);
    }
}