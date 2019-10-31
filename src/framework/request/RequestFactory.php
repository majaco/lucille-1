<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 */

namespace Lucille\Request;

use Lucille\Exceptions\UnsupportedRequestMethodException;
use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\RequestBodyFactory;
use Lucille\Request\Parameter\RequestParameterCollection;

/**
 * Class RequestFactory
 *
 * @package Lucille\Request
 */
class RequestFactory
{

    /**
     * @var array
     */
    private $globalGet;

    /**
     * @var array
     */
    private $globalPost;

    /**
     * @var array
     */
    private $globalServer;

    /**
     * @var array
     */
    private $cookie;

    /**
     * @var array
     */
    private $files;

    /**
     * @var string
     */
    private $inputStream;

    /**
     * @param array  $globalGet _GET source data
     * @param array  $globalPost _POST source data
     * @param array  $globalServer _SERVER source data
     * @param array  $cookie _COOKIE source data
     * @param array  $files _FILES source data
     * @param string $inputStream Input stream (default: php://input)
     */
    public function __construct(array $globalGet,
                                array $globalPost,
                                array $globalServer,
                                array $cookie,
                                array $files,
                                string $inputStream)
    {
        $this->globalGet    = $globalGet;
        $this->globalPost   = $globalPost;
        $this->globalServer = $globalServer;
        $this->cookie       = $cookie;
        $this->files        = $files;
        $this->inputStream  = $inputStream;
    }


    /**
     * @return Request
     * @throws UnsupportedRequestMethodException
     */
    public function createRequest(): Request
    {
        $url = new Uri($this->globalServer['REQUEST_URI']);

        // build header collection
        $headerCollection = HeaderCollection::fromSource($this->globalServer);

        switch (strtoupper($this->globalServer['REQUEST_METHOD'])) {
            case RequestMethod::GET:
            {
                $parameterCollection       = RequestParameterCollection::fromArray($this->globalGet);
                $cookieParameterCollection = RequestParameterCollection::fromArray($this->cookie);

                return new GetRequest($url, $headerCollection, $parameterCollection, $cookieParameterCollection);
            }
            case RequestMethod::POST:
            {
                $parameterCollection       = RequestParameterCollection::fromArray($this->globalPost);
                $requestBody               = RequestBodyFactory::fromStream($this->inputStream);
                $cookieParameterCollection = RequestParameterCollection::fromArray($this->cookie);
                $filesParameterCollection = RequestParameterCollection::fromArray($this->files);

                return new PostRequest(
                    $url,
                    $headerCollection,
                    $parameterCollection,
                    $cookieParameterCollection,
                    $requestBody,
                    $filesParameterCollection
                );
            }
            case RequestMethod::PUT:
            {
                $parameterCollection       = RequestParameterCollection::fromArray($this->globalGet);
                $requestBody               = RequestBodyFactory::fromStream($this->inputStream);
                $cookieParameterCollection = RequestParameterCollection::fromArray($this->cookie);

                return new PutRequest(
                    $url,
                    $headerCollection,
                    $parameterCollection,
                    $cookieParameterCollection,
                    $requestBody
                );
            }
            case RequestMethod::PATCH:
            {
                $parameterCollection       = RequestParameterCollection::fromArray($this->globalGet);
                $requestBody               = RequestBodyFactory::fromStream($this->inputStream);
                $cookieParameterCollection = RequestParameterCollection::fromArray($this->cookie);

                return new PatchRequest(
                    $url,
                    $headerCollection,
                    $parameterCollection,
                    $cookieParameterCollection,
                    $requestBody
                );
            }
            case RequestMethod::DELETE:
            {
                $parameterCollection       = RequestParameterCollection::fromArray($this->globalGet);
                $requestBody               = RequestBodyFactory::fromStream($this->inputStream);
                $cookieParameterCollection = RequestParameterCollection::fromArray($this->cookie);

                return new DeleteRequest(
                    $url,
                    $headerCollection,
                    $parameterCollection,
                    $cookieParameterCollection,
                    $requestBody
                );
            }
            default:
            {
                throw new UnsupportedRequestMethodException($this->globalServer['REQUEST_METHOD']);
            }
        }
    }

}
