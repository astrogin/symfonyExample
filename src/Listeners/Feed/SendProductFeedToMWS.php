<?php

namespace App\Listeners\Feed;

use App\Doctrine\Entity\Main\Feed;
use App\MwsClients\Feed\Container;
use App\MwsClients\Feed\Schemes\SubmitFeedBase;
use App\Services\FileSystem\FileSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SendProductFeedToMWS
{
    private $fileSystem;
    private $container;
    private $mws;
    private $em;

    public function __construct(
        FileSystem $fileSystem,
        ContainerInterface $container,
        Container $mws,
        EntityManagerInterface $entityManager
    )
    {
        $this->fileSystem = $fileSystem;
        $this->container = $container;
        $this->mws = $mws;
        $this->em = $entityManager;
    }

    /**
     * @param Event $event
     */
    public function __invoke(Event $event)
    {
        /**
         * @var $feed Feed
         */
        $feed = $event->getFeed();

        if (
            $feed->getType() === Feed::POST_PRODUCT_TYPE &&
            $xml = $this->fileSystem->getXml($feed->getPath())
        ) {

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

            $this->em->persist($feed);
            $this->em->flush();
        }
    }
}