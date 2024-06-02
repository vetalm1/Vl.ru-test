<?php
namespace App\Tests\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class KeywordsPhrasesGenerateControllerTest extends WebTestCase
{
    public function testGeneratePhrases(): void
    {
        $client = static::createClient();

        $payload = [
            'wordSetsList' => [
                'Honda, Honda CRF, Honda CRF-450X',
                'Владивосток, Приморский край -Владивосток',
                'продажа, покупка, цена, с пробегом'
            ]
        ];

        $client->request(
            'POST',
            '/api/v1/keyword-phrases-generate',
            $payload,
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('response', $responseContent);
        $this->assertIsArray($responseContent['response']);
    }
}