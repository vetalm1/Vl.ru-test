<?php

namespace App\Tests\Service;

use App\DTO\SentenceCombinationDTO;
use App\Service\KeywordsGenerationService;
use PHPUnit\Framework\TestCase;

class KeywordsGenerationServiceTest extends TestCase
{
    /** @test */
    public function testGeneratePhrasesList()
    {
        $dtoMock = $this->createMock(SentenceCombinationDTO::class);
        $dtoMock->method('getWordStringArray')
            ->willReturn([
                'Honda, Honda:;% CRF, Honda CRF-450X',
                'Владивосток, Приморский край -Владивосток',
                'продажа, покупка, цена, с пробегом'
            ]);

        $service = new KeywordsGenerationService();
        $result = $service->generatePhrasesList($dtoMock);

        $expected =  [
            "Honda Владивосток продажа",
            "Honda Владивосток покупка",
            "Honda Владивосток цена",
            "Honda Владивосток +с пробегом",
            "Honda Приморский край продажа -Владивосток",
            "Honda Приморский край покупка -Владивосток",
            "Honda Приморский край цена -Владивосток",
            "Honda Приморский край +с пробегом -Владивосток",
            "Honda CRF Владивосток продажа",
            "Honda CRF Владивосток покупка",
            "Honda CRF Владивосток цена",
            "Honda CRF Владивосток +с пробегом",
            "Honda CRF Приморский край продажа -Владивосток",
            "Honda CRF Приморский край покупка -Владивосток",
            "Honda CRF Приморский край цена -Владивосток",
            "Honda CRF Приморский край +с пробегом -Владивосток",
            "Honda CRF 450X Владивосток продажа",
            "Honda CRF 450X Владивосток покупка",
            "Honda CRF 450X Владивосток цена",
            "Honda CRF 450X Владивосток +с пробегом",
            "Honda CRF 450X Приморский край продажа -Владивосток",
            "Honda CRF 450X Приморский край покупка -Владивосток",
            "Honda CRF 450X Приморский край цена -Владивосток",
            "Honda CRF 450X Приморский край +с пробегом -Владивосток"
        ];

        $this->assertEquals($expected, $result);
    }
}