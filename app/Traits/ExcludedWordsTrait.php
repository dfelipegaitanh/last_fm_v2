<?php

namespace App\Traits;

/**
 * Trait ExcludedWordsTrait
 *
 * Este trait proporciona una funcionalidad para limpiar textos eliminando ciertas palabras
 * y patrones predefinidos, como menciones a versiones remasterizadas, años y caracteres
 * innecesarios como paréntesis vacíos.
 *
 * Métodos:
 * - cleanText(string $text): string
 *   Elimina palabras excluidas, años en formato de cuatro dígitos y otros patrones específicos.
 *
 * - removeExcludedPatterns(string $text): string
 *   Elimina palabras clave y patrones definidos en la propiedad $excludedWords.
 *
 * - removeEmptyParentheses(string $text): string
 *   Elimina paréntesis vacíos que puedan quedar tras la limpieza del texto.
 */
trait ExcludedWordsTrait
{
    protected array $excludedWords = [
        'Remasterizado',
        'Remastered',
        'Remaster',
        '(Remasterizado)',
        '(Remastered)',
        '(Remaster)',
    ];

    public function cleanText(string $text): string
    {
        $text = $this->removeExcludedPatterns($text);
        $text = $this->removeEmptyParentheses($text);

        return trim($text);
    }

    private function removeExcludedPatterns(string $text): string
    {
        $escapedWords = array_map(fn ($word): string => preg_quote($word, '/'), $this->excludedWords);
        $wordsPattern = implode('|', $escapedWords);
        $pattern = sprintf(
            '/(?:\s-\s|-\s|\s-)?(?:%s|\d{4}|Remaster(?:izado|ed)?)\b/i',
            $wordsPattern
        );

        return preg_replace($pattern, '', $text);
    }

    private function removeEmptyParentheses(string $text): string
    {
        return preg_replace('/\(\s*\)/', '', $text);
    }
}
