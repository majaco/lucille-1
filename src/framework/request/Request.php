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
use Lucille\Request\Parameter\RequestParameter;
use Lucille\Request\Parameter\RequestParameterCollection;

/**
 * Class Request
 *
 * @package Lucille\Request
 */
abstract class Request {

    /**
     * @var Uri
     */
    private $uri;

    /**
     * @var HeaderCollection
     */
    private $headerCollection;

    /**
     * @var RequestParameterCollection
     */
    private $parameterCollection;

    /**
     * @var RequestParameterCollection
     */
    private $cookieParameterCollection;

    /**
     * @param Uri                        $uri                       Request Uir object
     * @param HeaderCollection           $headerCollection          Header Collection
     * @param RequestParameterCollection $parameterCollection       GET/POST parameters
     * @param RequestParameterCollection $cookieParameterCollection Cookie parameters
     */
    public function __construct(
        Uri $uri,
        HeaderCollection $headerCollection,
        RequestParameterCollection $parameterCollection,
        RequestParameterCollection $cookieParameterCollection
    ) {
        $this->uri = $uri;
        $this->headerCollection = $headerCollection;
        $this->parameterCollection = $parameterCollection;
        $this->cookieParameterCollection = $cookieParameterCollection;
    }

    /**
     * @return Uri
     */
    public function getUri(): Uri {
        return $this->uri;
    }

    /**
     * @return HeaderCollection
     */
    public function getHeaderCollection(): HeaderCollection {
        return $this->headerCollection;
    }

    /**
     * @param string|null $name Parameter collection name
     * @return RequestParameterCollection
     * @throws \Lucille\Exceptions\RequestParameterCollectionNotFoundException
     */
    public function getParameterCollection(string $name = null): RequestParameterCollection {
        if ($name !== null) {
            return $this->parameterCollection->getParameterCollection($name);
        }
        return $this->parameterCollection;
    }

    /**
     * @param string $name Request parameter name
     * @return RequestParameter
     * @throws \Lucille\Exceptions\RequestParameterNotFoundException
     */
    public function getParam(string $name): RequestParameter {
        return $this->parameterCollection->getParam($name);
    }

    public function hasParam(string $name): bool {
        return $this->parameterCollection->hasParam($name);
    }

    public function hasParameterCollection(string $name): bool {
        if (!isset($this->parameterCollection[$name])) {
            return false;
        }
        return true;
    }

    /**
     * @param string|null $name Parameter collection name
     * @return RequestParameterCollection
     * @throws \Lucille\Exceptions\RequestParameterCollectionNotFoundException
     */
    public function getCookieParameterCollection(string $name = null): RequestParameterCollection {
        if ($name !== null) {
            return $this->cookieParameterCollection->getParameterCollection($name);
        }
        return $this->parameterCollection;
    }

    /**
     * @param string $name Request parameter name
     * @return RequestParameter
     * @throws \Lucille\Exceptions\RequestParameterNotFoundException
     */
    public function getCookieParam(string $name): RequestParameter {
        return $this->cookieParameterCollection->getParam($name);
    }

}
