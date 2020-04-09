<?php

namespace App\MwsClients\Feed\Schemes\SubmissionFeedResult;

use Symfony\Component\Serializer\Encoder\XmlEncoder;

class ResponseSubmissionFeedResult
{
    const STATUS_COMPLETED = 'Complete';
    const ERROR_MESSAGE_TYPE = 'Error';

    private $response;

    public function __construct(string $xml)
    {
        $encoder = new XmlEncoder();

        $this->response = $encoder->decode($xml, $encoder::FORMAT);
    }

    public function isError()
    {
        if (
            array_key_exists('Message', $this->response) &&
            array_key_exists('ProcessingReport', $this->response['Message']) &&
            array_key_exists('ProcessingSummary', $this->response['Message']['ProcessingReport']) &&
            array_key_exists('MessagesProcessed', $this->response['Message']['ProcessingReport']['ProcessingSummary']) &&
            array_key_exists('MessagesSuccessful', $this->response['Message']['ProcessingReport']['ProcessingSummary']) &&
            array_key_exists('MessagesWithError', $this->response['Message']['ProcessingReport']['ProcessingSummary']) &&
            array_key_exists('MessagesWithWarning', $this->response['Message']['ProcessingReport']['ProcessingSummary'])
        ) {
            $summary = $this->response['Message']['ProcessingReport']['ProcessingSummary'];

            if (
                (int)$summary['MessagesProcessed'] > 0 &&
                (int)$summary['MessagesSuccessful'] > 0 &&
                (int)$summary['MessagesWithError'] === 0 &&
                (int)$summary['MessagesWithWarning'] === 0
            ) {
                return false;
            }

            return true;
        }

        return true;
    }

    public function isCompleted()
    {
        if (
            array_key_exists('Message', $this->response) &&
            array_key_exists('ProcessingReport', $this->response['Message']) &&
            array_key_exists('StatusCode', $this->response['Message']['ProcessingReport'])
        ) {
            return $this->response['Message']['ProcessingReport']['StatusCode'] === self::STATUS_COMPLETED;
        }

        return false;
    }

    public function getErrors()
    {
        $subErrors = [];

        if (
            array_key_exists('Message', $this->response) &&
            array_key_exists('ProcessingReport', $this->response['Message']) &&
            array_key_exists('Result', $this->response['Message']['ProcessingReport'])
        ) {

            $errors = $this->response['Message']['ProcessingReport']['Result'];

            foreach ($errors as $error) {

                if (array_key_exists('ResultCode', $error) && $error['ResultCode'] === self::ERROR_MESSAGE_TYPE) {

                    $code = array_key_exists('ResultMessageCode', $error) ? $error['ResultMessageCode'] : '0';
                    $message = array_key_exists('ResultDescription', $error) ? $error['ResultDescription'] : 'No message';

                    $subErrors[] = new ErrorSubmissionFeedResult($code, $message);
                }
            }
        }

        return $subErrors;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
