<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Routing;
    
use Lucille\Exceptions\RoutingChainConfigurationException;
use Lucille\Response\Response;
use Lucille\Result\Result;

/**
 * Class ResultRouter
 *
 * @package Lucille\Routing
 */
abstract class ResultRouter {
    
    /**
     * @var ResultRouter
     */
    private $next;
    
    /**
     * @param ResultRouter $router Result router instance
     * @return void
     */
    public function setNext(ResultRouter $router): void {
        $this->next = $router;
    }

    public function hasNext(): bool {
        if ($this->next === null) {
            return false;
        }
        return true;
    }

    /**
     * @return ResultRouter
     * @throws RoutingChainConfigurationException
     */
    public function getNext(): ResultRouter {
        if ($this->next === null) {
            throw new RoutingChainConfigurationException('Cannot prepare next router');
        }
        return $this->next;
    }
    
    /**
     * @param Result $result Router result
     * @return Response
     */
    abstract public function route(Result $result): Response;
    
}
