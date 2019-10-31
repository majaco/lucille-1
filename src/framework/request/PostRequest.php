<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Matthias Jacobi <mail@majaco.de>
 *
 */

namespace Lucille\Request;

use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\RequestBody;
use Lucille\Request\Parameter\RequestParameterCollection;

/**
 * Class PostRequest
 *
 * @package Lucille\Request
 */
class PostRequest extends Request {

    /**
     * @var RequestBody
     */
    private $requestBody;

    /**
     * @var RequestParameterCollection
     */
    private $files;

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
        RequestBody $requestBody,
        RequestParameterCollection $filesParameterCollection
    ) {
        parent::__construct($uri, $headerCollection, $parameterCollection, $cookieParameterCollection);
        $this->requestBody = $requestBody;
        $this->filesParameterCollection = $filesParameterCollection;
    }

    /**
     * @return RequestBody
     */
    public function getBody(): RequestBody {
        return $this->requestBody;
    }

    public function getFilesParameterCollection(): RequestParameterCollection
    {
        return $this->filesParameterCollection;
    }
}
