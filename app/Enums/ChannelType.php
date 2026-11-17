<?php

namespace App\Enums;

enum ChannelType: string
{
    case LinkedIn = 'linkedin';
    case X = 'x';
    case Newsletter = 'newsletter';
    case YouTube = 'youtube';
    case Blog = 'blog';
    case ShortForm = 'short_form';
    case Threads = 'threads';
    case Carousel = 'carousel';

    public function label(): string
    {
        return config("repurpose.channels.{$this->value}", $this->value);
    }
}