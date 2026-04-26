<?php

namespace App\Support;

class TextFormatter
{
    public function productDescription(?string $text): string
    {
        $escaped = e((string) $text);

        $formatted = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $escaped);
        $formatted = preg_replace('/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s', '<em>$1</em>', $formatted ?? $escaped);
        $formatted = preg_replace('/\+\+(.+?)\+\+/s', '<u>$1</u>', $formatted ?? $escaped);

        return nl2br($formatted ?? $escaped);
    }
}
