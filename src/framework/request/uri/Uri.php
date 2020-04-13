<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 */

namespace Lucille\Request;

use Lucille\Exceptions\UriPartIndexOutOfBoundsException;

/**
 * Class Uri
 *
 * @package Lucille\Request
 */
class Uri
{

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $uri Original request Uri
     */
    public function __construct(string $uri)
    {
        $this->uri  = trim($uri);
        $this->path = parse_url($this->uri, PHP_URL_PATH);
        if ($this->path !== '/') {
            $this->path = rtrim($this->path, '/');
        }
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function originUriAsString(): string
    {
        return $this->uri;
    }

    /**
     * @throws UriPartIndexOutOfBoundsException
     * @return string
     * @param int $index URI path index value
     */
    public function getPart(int $index): UriPart
    {
        $tmp = explode('/', trim(urldecode($this->asString()), '/'));

        if ($index >= count($tmp) || $index < 0) {
            throw new UriPartIndexOutOfBoundsException("No uri segment found for given index value");
        }
        return new UriPart($tmp[$index]);
    }

    public function getPartAsStringOrNull(int $index): ?string
    {
        try {
            return $this->getPart($index)->asString();
        } catch (UriPartIndexOutOfBoundsException $e) {
        }
        return null;
    }

    /**
     * @param int $index URI path index value
     * @return bool
     */
    public function hasPart(int $index): bool
    {
        $tmp = explode('/', trim(urldecode($this->asString()), '/'));

        if ($index >= count($tmp) || $index < 0) {
            return false;
        }
        return true;
    }

    /**
     * @param Uri $uri Uri reference
     * @return bool
     */
    public function isEqual(Uri $uri): bool
    {
        return $this->asString() === $uri->asString();
    }

    /**
     * @param Uri $uri Uri reference
     * @return bool
     */
    public function beginsWith(Uri $uri): bool
    {
        if (substr($this->path, 0, strlen($uri->asString())) === $uri->asString()) {
            return true;
        }
        return false;
    }

    /**
     * @param UriRegEx $regexPattern RegEx pattern
     * @return bool
     */
    public function matchesRegEx(UriRegEx $regexPattern): bool
    {
        $rc = preg_match($regexPattern->asString(), $this->path, $m);
        return ($rc > 0 ? true : false);
    }

}
