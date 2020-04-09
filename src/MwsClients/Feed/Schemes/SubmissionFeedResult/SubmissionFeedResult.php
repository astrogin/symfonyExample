<?php

namespace App\MwsClients\Feed\Schemes\SubmissionFeedResult;

class SubmissionFeedResult
{
    /**
     * @var string
     */
    private $merchant;
    /**
     * @var string
     */
    private $submissionFeedId;
    /**
     * @var mixed
     */
    private $resource;

    /**
     * SubmissionFeedResult constructor.
     * @param string $merchant
     * @param string $submissionFeedId
     * @param mixed $resource
     */
    public function __construct(string $merchant, string $submissionFeedId, $resource)
    {
        $this->merchant = $merchant;
        $this->submissionFeedId = $submissionFeedId;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getMerchant(): string
    {
        return $this->merchant;
    }

    /**
     * @param string $merchant
     */
    public function setMerchant(string $merchant): void
    {
        $this->merchant = $merchant;
    }

    /**
     * @return string
     */
    public function getSubmissionFeedId(): string
    {
        return $this->submissionFeedId;
    }

    /**
     * @param string $submissionFeedId
     */
    public function setSubmissionFeedId(string $submissionFeedId): void
    {
        $this->submissionFeedId = $submissionFeedId;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }
}