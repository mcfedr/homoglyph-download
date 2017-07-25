<?php

namespace AppBundle\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class HomoglyphDownloadCommand extends Command
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $defaultUrl;

    public function __construct(Client $client, string $defaultUrl)
    {
        $this->client = $client;
        $this->defaultUrl = $defaultUrl;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('download')
            ->setDescription('Download and out the homoglyphs')
            ->addOption('url', null, InputOption::VALUE_REQUIRED, 'Change the url to download from', $this->defaultUrl);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('url');
        $response = $this->client->get($url);
        $content = $response->getBody()->getContents();

        $crawler = new Crawler(null, $url);
        $crawler->addContent($content, $response->getHeaderLine('content-type'));

        $replacements = [];
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-$';

        $rows = $crawler->filter('#Rangestable .hglistod,.hglistev');
        $rows->each(function (Crawler $node, $i) use (&$replacements, $letters) {
            $letter = $node->filter('.charleft')->text();
            if (strpos($letters, $letter) === false) {
                return;
            }
            $node->filter('.char,.charright')->each(function (Crawler $node, $i) use ($letter, &$replacements) {
                $text = $node->text();
                $text = str_replace(chr(194).chr(160), '', $text);
                if ($text) {
                    $replacements[$text] = $letter;
                }
            });
        });

        $output->writeln(var_export($replacements, true));
    }
}
