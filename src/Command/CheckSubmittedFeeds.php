<?php

namespace App\Command;

use App\Doctrine\Entity\Main\Feed;
use App\MwsClients\Feed\Container;
use App\MwsClients\Feed\Events\Product\ProductFeedSuccessEvent;
use App\MwsClients\Feed\Schemes\SubmissionFeedResult\ResponseSubmissionFeedResult;
use App\MwsClients\Feed\Schemes\SubmissionFeedResult\SubmissionFeedResult;
use App\Services\FileSystem\FileSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CheckSubmittedFeeds extends Command
{
    protected static $defaultName = 'app:check-submitted-feeds';

    private $entityManager;
    private $container;
    private $fileSystem;
    private $dispatcher;
    private $mws;

    /**
     * CheckSubmittedFeeds constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     * @param FileSystem $fileSystem
     * @param EventDispatcherInterface $dispatcher
     * @param Container $mws
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
        /**
         * @var $feed Feed
         */
        $feed = $em->getRepository(Feed::class)
            ->findOneBy(['status' => Feed::SUBMITTED_STATUS]);

        if ($feed) {

            $resource = @fopen('php://memory', 'rw+');

            $submissionFeedResult = new SubmissionFeedResult(
                $this->container->getParameter('env.merchant'),
                $feed->getSubmissionId(),
                $resource
            );

            $request = $this->mws->prepare($this->mws::PREPARE_FEED_SUBMISSION_RESULT_METHOD, $submissionFeedResult);

            $this->mws->send($this->mws::GET_FEED_SUBMISSION_RESULT_METHOD, $request);

            rewind($resource);

            $response = new ResponseSubmissionFeedResult(stream_get_contents($resource));

            if ($response->isCompleted()) {

                if ($response->isError()) {

                    $feed->setStatus($feed::ERROR_STATUS);
                    $em->flush();
                } else {

                    $feed->setStatus($feed::DONE_STATUS);
                    $em->flush();

                    if ($feed->getType() === $feed::POST_PRODUCT_TYPE) {
                        $this->dispatcher->dispatch(new ProductFeedSuccessEvent($feed), ProductFeedSuccessEvent::NAME);
                    }
                }
            }
        }

        return 1;
    }
}