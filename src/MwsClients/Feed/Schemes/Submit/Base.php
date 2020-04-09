<?php

namespace App\MwsClients\Feed\Schemes\Submit;

use App\Persistence\Feed\BaseType;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Base implements BaseType
{
    const PRODUCT_MESSAGE_TYPE = 'Product';
    const PRODUCT_IMAGE_MESSAGE_TYPE = 'ProductImage';
    const PRODUCT_INVENTORY_MESSAGE_TYPE = 'Inventory';
    const PRODUCT_PRICE_MESSAGE_TYPE = 'Price';
    /**
     * @var string
     */
    private $merchant;

    /**
     * @var string
     */
    private $messageType;
    /**
     * @var array
     */
    private $messages;

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
    public function getMessageType(): string
    {
        return $this->messageType;
    }

    /**
     * @param string $messageType
     */
    public function setMessageType(string $messageType): void
    {
        $this->messageType = $messageType;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    public function toArray(): array
    {
        $parsedMessage = [];
        $messageNumber = 1;
        $messages = $this->getMessages();

        foreach ($messages as $message) {

            $tempMessage = [
                'MessageID' => $messageNumber,
                'OperationType' => 'Update',
            ];

            $tempMessage[$this->getMessageType()] = $message->toArray();

            $parsedMessage[] = $tempMessage;

            $messageNumber++;
        }

        return [
            '@xsi:noNamespaceSchemaLocation' => 'amzn-envelope.xsd',
            '@xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'Header' => [
                'DocumentVersion' => '1.01',
                'MerchantIdentifier' => $this->getMerchant(),
            ],
            'MessageType' => $this->getMessageType(),
            'PurgeAndReplace' => 'false',
            'Message' => $parsedMessage
        ];
    }

    /**
     * @param array $data
     */
    public function castFromArray(array $data)
    {
        !array_key_exists('merchant', $data) ?: $this->setMerchant($data['merchant']);
        !array_key_exists('messageType', $data) ?: $this->setMessageType($data['messageType']);
        !array_key_exists('messages', $data) ?: $this->setMessages($data['messages']);
    }

    /**
     * @return bool|float|int|string
     */
    public function toXml()
    {
        $xmlEncoder = new XmlEncoder([
            XmlEncoder::ROOT_NODE_NAME => 'AmazonEnvelope',
            XmlEncoder::ENCODING => 'utf-8'
        ]);
        $feed = $this->toArray();

        return $xmlEncoder->encode($feed, $xmlEncoder::FORMAT);
    }
}