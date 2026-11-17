<?php

namespace App\Services;

class TranscriptCleanupService
{
    public function __construct(private ModuleManager $modules) {}

    public function clean(string $raw): string
    {
        $this->modules->guard('transcript_cleanup');

        $text = preg_replace('/\[[0-9]{1,2}:[0-9]{2}(?::[0-9]{2})?\]/', '', $raw) ?? $raw;
        $text = preg_replace('/\b(um+|uh+|you know|like)\b/i', '', $text) ?? $text;
        $text = preg_replace('/\s{2,}/', ' ', $text) ?? $text;
        $text = preg_replace('/\n{3,}/', "\n\n", $text) ?? $text;

        return trim($text);
    }
}