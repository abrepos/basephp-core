<?php
/**
 * @project BasePHP Core
 * @file ApplicationDelegate.php created by Ariel Bogdziewicz on 29/07/2018
 * @author Ariel Bogdziewicz
 * @copyright Copyright © 2018 Ariel Bogdziewicz. All rights reserved.
 * @license MIT
 */
namespace Base\Core;

use Base\Exceptions\Exception;
use Base\Responses\Response;

/**
 * Interface ApplicationDelegate
 * @package Base\Core
 */
interface ApplicationDelegate
{
    /**
     * It is good place to open common resources for all controllers
     * like database connection or other settings. They should be owned
     * by application delegate.
     */
    function open(): void;

    /**
     * Registers all routes for project.
     * @param Router $router
     *      Router object which has to be used to register routes.
     */
    function registerRoutes(Router $router): void;
    
    /**
     * Returns current request path. It depends on custom
     * project settings or custom rewrite rules for incoming URL.
     * This path will be processed by router.
     * @param Request $request
     *      Request object which can be used to get current request path.
     * @return string
     *      Current request path.
     */
    function currentRequestPath(Request $request): string;

    /**
     * Returns domain for current session.
     *
     * If wildcard domain is returned with dot at the beginning like ".example.com"
     * then session will be available in all subdomains.
     *
     * If specific domain is returned without dot at the beginning like "example.com",
     * "subdomain.example.com" or null then session will be available only for current hostname.
     *
     * @param Request $request
     * @return string
     */
    function sessionDomain(Request $request): string;

    /**
     * Returns response for exception which is defined by BasePHP Core.
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    function responseForException(Request $request, Exception $exception): Response;

    /**
     * Returns response for throwable.
     * @param Request $request
     * @param \Throwable $throwable
     * @return Response
     */
    function responseForThrowable(Request $request, \Throwable $throwable): Response;

    /**
     * It is good place to close common resources which are owned by application delegate.
     */
    function close(): void;
}
