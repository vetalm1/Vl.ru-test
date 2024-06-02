<?php

namespace App\Controller\Api\KeywordsPhrasesGenerate\v1;


use App\DTO\SentenceCombinationDTO;
use App\Service\KeywordsGenerationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/keyword-phrases-generate')]
class Controller extends AbstractController
{
    public function __construct(private readonly KeywordsGenerationService $keywordsGenerationService)
    {
    }

    #[Route(path: '', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $wordSetsList = $request->get('wordSetsList');

        $wordSetsListDTO = new SentenceCombinationDTO($wordSetsList);

        $generatedPhrases = $this->keywordsGenerationService->generatePhrasesList($wordSetsListDTO);

        return $this->json(['response' => $generatedPhrases]);
    }

}