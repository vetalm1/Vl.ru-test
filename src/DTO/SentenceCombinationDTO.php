<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SentenceCombinationDTO
{
    /**
     * Массив строк, каждая из которых содержит слова, разделенные запятыми.
     * @Assert\NotBlank
     * @Assert\Type("array")
     * @Assert\All({
     *     @Assert\Type("string")
     * })
     */
    private array $wordStringArray;

    public function __construct($wordStringArray)
    {
        $this->wordStringArray = $wordStringArray;
    }

    public function getWordStringArray(): array
    {
        return $this->wordStringArray;
    }
}