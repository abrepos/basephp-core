<?php
/**
 * @project BasePHP Core
 * @file HttpResponse.php created by Ariel Bogdziewicz on 29/07/2018
 * @author Ariel Bogdziewicz
 * @copyright Copyright © 2018 Ariel Bogdziewicz. All rights reserved.
 * @license MIT
 */
namespace Base\Http;

use Base\Data\Data;

/**
 * Class HttpResponse represents HTTP response.
 * @package Base\Http
 */
class HttpResponse
{
    /**
     * HTTP code.
     * @var int
     */
    protected $httpCode;

    /**
     * HTTP header.
     * @var HttpHeader
     */
    protected $header;

    /**
     * Content of response.
     * @var Data
     */
    protected $content;

    /**
     * HttpResponse constructor.
     * @param int $httpCode
     * @param HttpHeader $header
     * @param Data $content
     */
    public function __construct(int $httpCode, HttpHeader $header = null, Data $content = null)
    {
        $this->httpCode = $httpCode;
        $this->header = $header ?? new HttpHeader([]);
        $this->content = $content;
    }

    /**
     * Returns HTTP code of response.
     * @return int
     */
    public function httpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Returns HTTP header.
     * @return HttpHeader
     */
    public function header(): HttpHeader
    {
        return $this->header;
    }

    /**
     * Content of response.
     * @return Data
     */
    public function content(): ?Data
    {
        return $this->content;
    }

    /**
     * Returns response as string.
     */
    public function __toString()
    {
        $data = $this->content();
        return $data ? $data->content() : "";
    }
}
