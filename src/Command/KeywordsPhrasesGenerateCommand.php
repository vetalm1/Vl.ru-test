<?php
namespace App\Command;

use App\DTO\SentenceCombinationDTO;
use App\Service\KeywordsGenerationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'keywords-phrases:generate')]
class KeywordsPhrasesGenerateCommand extends Command
{
    public function __construct( private readonly KeywordsGenerationService $keywordsGenerationService, ?string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('KeywordsPhrasesGenerateCommand');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $wordSetsList = [];

        while (true) {
            $question = new Question('Введите список слов через запятую (либо нажмите enter для окончания ввода): ');
            $response = $helper->ask($input, $output, $question);

            if (empty($response)) {break;}

            $wordSetsList[] = $response;
        }

        $wordSetsListDTO = new SentenceCombinationDTO($wordSetsList);

        $generatedPhrases = $this->keywordsGenerationService->generatePhrasesList($wordSetsListDTO);

        foreach ($generatedPhrases as $phrase) {
            echo $phrase . PHP_EOL;
        }

        return Command::SUCCESS;
    }
}