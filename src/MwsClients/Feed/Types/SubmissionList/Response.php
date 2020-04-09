<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/******************************************************************************* 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */
namespace App\MwsClients\Feed\Types\SubmissionList;


use App\MwsClients\Feed\Types\Base;
use App\MwsClients\Feed\Types\ResponseMetadata;
use DOMDocument;
use DOMXPath;
use Exception;

/**
 *  @see Base
 */

    

/**
 * Response
 * 
 * Properties:
 * <ul>
 * 
 * <li>GetFeedSubmissionListResult: Result</li>
 * <li>ResponseMetadata: ResponseMetadata</li>
 *
 * </ul>
 */ 
class Response extends Base
{


    /**
     * Construct new Response
     * 
     * @param mixed $data DOMElement or Associative Array to construct from.
     * @throws \Exception
     * 
     * Valid properties:
     * <ul>
     * 
     * <li>GetFeedSubmissionListResult: Result</li>
     * <li>ResponseMetadata: ResponseMetadata</li>
     *
     * </ul>
     */
    public function __construct($data = null)
    {
        $this->fields = array (
        'GetFeedSubmissionListResult' => array('FieldValue' => null, 'FieldType' => Result::class),
        'ResponseMetadata' => array('FieldValue' => null, 'FieldType' => ResponseMetadata::class),
        );
        parent::__construct($data);
    }

       
    /**
     * Construct MarketplaceWebService_Model_GetFeedSubmissionListResponse from XML string
     * 
     * @param string $xml XML string to construct from
     * @return Response
     * @throws \Exception;
     */
    public static function fromXML($xml)
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $xpath = new DOMXPath($dom);
    	$xpath->registerNamespace('a', 'http://mws.amazonaws.com/doc/2009-01-01/');
        $response = $xpath->query('//a:GetFeedSubmissionListResponse');
        if ($response->length == 1) {
            return new Response(($response->item(0)));
        } else {
            throw new Exception ("Unable to construct MarketplaceWebService_Model_GetFeedSubmissionListResponse from provided XML. 
                                  Make sure that GetFeedSubmissionListResponse is a root element");
        }
          
    }
    
    /**
     * Gets the value of the GetFeedSubmissionListResult.
     * 
     * @return Result GetFeedSubmissionListResult
     */
    public function getGetFeedSubmissionListResult() 
    {
        return $this->fields['GetFeedSubmissionListResult']['FieldValue'];
    }

    /**
     * Sets the value of the GetFeedSubmissionListResult.
     * 
     * @param Result GetFeedSubmissionListResult
     * @return void
     */
    public function setGetFeedSubmissionListResult($value) 
    {
        $this->fields['GetFeedSubmissionListResult']['FieldValue'] = $value;
        return;
    }

    /**
     * Sets the value of the GetFeedSubmissionListResult  and returns this instance
     * 
     * @param Result $value GetFeedSubmissionListResult
     * @return $this instance
     */
    public function withGetFeedSubmissionListResult($value)
    {
        $this->setGetFeedSubmissionListResult($value);
        return $this;
    }


    /**
     * Checks if GetFeedSubmissionListResult  is set
     * 
     * @return bool true if GetFeedSubmissionListResult property is set
     */
    public function isSetGetFeedSubmissionListResult()
    {
        return !is_null($this->fields['GetFeedSubmissionListResult']['FieldValue']);

    }

    /**
     * Gets the value of the ResponseMetadata.
     * 
     * @return ResponseMetadata ResponseMetadata
     */
    public function getResponseMetadata() 
    {
        return $this->fields['ResponseMetadata']['FieldValue'];
    }

    /**
     * Sets the value of the ResponseMetadata.
     * 
     * @param ResponseMetadata ResponseMetadata
     * @return void
     */
    public function setResponseMetadata($value) 
    {
        $this->fields['ResponseMetadata']['FieldValue'] = $value;
        return;
    }

    /**
     * Sets the value of the ResponseMetadata  and returns this instance
     * 
     * @param ResponseMetadata $value ResponseMetadata
     * @return $this instance
     */
    public function withResponseMetadata($value)
    {
        $this->setResponseMetadata($value);
        return $this;
    }


    /**
     * Checks if ResponseMetadata  is set
     * 
     * @return bool true if ResponseMetadata property is set
     */
    public function isSetResponseMetadata()
    {
        return !is_null($this->fields['ResponseMetadata']['FieldValue']);

    }



    /**
     * XML Representation for this object
     * 
     * @return string XML for this object
     */
    public function toXML() 
    {
        $xml = "";
        $xml .= "<GetFeedSubmissionListResponse xmlns=\"http://mws.amazonaws.com/doc/2009-01-01/\">";
        $xml .= $this->_toXMLFragment();
        $xml .= "</GetFeedSubmissionListResponse>";
        return $xml;
    }

    private $_responseHeaderMetadata = null;

    public function getResponseHeaderMetadata() {
      return $this->_responseHeaderMetadata;
    }

    public function setResponseHeaderMetadata($responseHeaderMetadata) {
      return $this->_responseHeaderMetadata = $responseHeaderMetadata;
    }
}
