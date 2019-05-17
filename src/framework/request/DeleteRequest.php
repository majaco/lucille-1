<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request;

use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\RequestBody;
use Lucille\Request\Parameter\RequestParameterCollection;

/**
 * Class DeleteRequest
 *
 * @package Lucille\Request
 */
class DeleteRequest extends Request {
    
    /**
     * @var RequestBody
     */
    private $requestBody;

    /**
     * @param Uri                        $uri                       Request Uir object
     * @param HeaderCollection           $headerCollection          Header Collection
     * @param RequestParameterCollection $parameterCollection       GET/POST parameters
     * @param RequestParameterCollection $cookieParameterCollection Cookie parameters
     * @param RequestBody                $requestBody               POST request body
     */
    public function __construct(
        Uri $uri,
        HeaderCollection $headerCollection,
        RequestParameterCollection $parameterCollection,
        RequestParameterCollection $cookieParameterCollection,
        RequestBody $requestBody
    ) {
        parent::__construct($uri, $headerCollection, $parameterCollection, $cookieParameterCollection);
        $this->requestBody = $requestBody;
    }
    
    /**
     * @return RequestBody
     */
    public function getBody(): RequestBody {
        return $this->requestBody;
    }
    
}
