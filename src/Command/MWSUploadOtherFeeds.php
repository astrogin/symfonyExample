<?php

namespace App\Command;

use App\Doctrine\Entity\Main\Feed;
use App\MwsClients\Feed\Container;
use App\MwsClients\Feed\Schemes\SubmitFeedBase;
use App\Services\FileSystem\FileSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MWSUploadOtherFeeds extends Command
{
    protected static $defaultName = 'app:mws-upload-other-feeds';

    private $entityManager;
    private $container;
    private $fileSystem;
    private $dispatcher;
    private $mws;

    /**
     * MWSUploadProducts constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     * @param FileSystem $fileSystem
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ContainerInterface $container,
        FileSystem $fileSystem,
        EventDispatcherInterface $dispatcher,
        Container $mws
    )
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->fileSystem = $fileSystem;
        $this->dispatcher = $dispatcher;
        $this->mws = $mws;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->entityManager;

        $feed = $em->getRepository(Feed::class)
            ->findOneBy(['status' => Feed::NEW_STATUS]);


        if ($feed) {

            $xml = $this->fileSystem->getXml($feed->getPath());

            if (!$xml) {
                $feed->setStatus($feed::ERROR_STATUS);
                $em->flush();
                return 0;
            }

            $feedType = new SubmitFeedBase(
                $xml->asXML(),
                $this->container->getParameter('env.merchant'),
                $this->container->getParameter('app.marketplace.id.list'),
                $feed->getType()
            );

            $request = $this->mws->prepare($this->mws::PREPARE_SUBMISSION_FEED_METHOD, $feedType);

            $response = $this->mws->send($this->mws::SUBMIT_FEED_METHOD, $request);

            if ($response->isSetSubmitFeedResult()) {

                $submitFeedResult = $response->getSubmitFeedResult();

                if ($submitFeedResult->isSetFeedSubmissionInfo()) {

                    $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();

                    if ($feedSubmissionInfo->isSetFeedSubmissionId()) {
                        $feed->setSubmissionId($feedSubmissionInfo->getFeedSubmissionId());
                    }

                    if ($feedSubmissionInfo->isSetFeedProcessingStatus()) {
                        $feed->setStatus($feedSubmissionInfo->getFeedProcessingStatus());
                    }
                }
            }

            $em->flush();
        }

        return 1;
    }
}