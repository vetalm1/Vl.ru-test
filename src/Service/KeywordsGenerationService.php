<?php

namespace App\Service;

use App\DTO\SentenceCombinationDTO;

class KeywordsGenerationService
{
    public array $result = [];

    /**
     * Phrases generate
     */
    public function generatePhrasesList(SentenceCombinationDTO $wordSetsListDTO): array
    {
        $wordsSetsArray = array_map(function($line) {
            $line = $this->clearPunctuationExcept($line);
            return explode(',', $line);
        }, $wordSetsListDTO->getWordStringArray());

        $this->generateCombinations($wordsSetsArray, 0, []);

        return $this->result;
    }

    /**
     * Words combination generation.
     *
     * @param array $wordsArray
     * @param int $index current index words sets
     * @param array $current current combination
     */
    private function generateCombinations(array $wordsArray, int $index, array $current): void
    {
        if ($index === count($wordsArray)) {
            $currentResultPhrase = implode(' ',  $current);
            $currentResultPhrase = $this->addPlusBeforeTwoSymbolsWord($currentResultPhrase);
            $this->result[] = $this->moveNegativeWordToEndOfPhrase($currentResultPhrase);
            return ;
        }

        foreach ($wordsArray[$index] as $word) {

            $current[] = trim($word);
            $this->generateCombinations($wordsArray, $index + 1, $current);
            array_pop($current);
        }
    }

    private function moveNegativeWordToEndOfPhrase($wordOrPhrase): string
    {
        $explodedWords = explode(' ', $wordOrPhrase);
        $removedWord = '';

        /* Find word start with "-" */
        foreach ($explodedWords as $key => $word) {
            if (str_starts_with($word, '-')) {
                $removedWord .= ' ' . $word;
                unset($explodedWords[$key]);
            }
        }

        return implode(' ', $explodedWords) . $removedWord ;
    }

    private function addPlusBeforeTwoSymbolsWord($word): string
    {
        return preg_replace('/\b(\w{1,2})\b/u', '+$1', $word);
    }

    /**
     * clear all punctuation except , + - !
     * replace '-' on space
     */
    private function clearPunctuationExcept(string $string): string
    {
        $string = preg_replace('/[^\w\s,!+-]/u', '', $string);

         return  preg_replace('/(?<=\w)-(?=\w)/', ' ', $string);
    }
}