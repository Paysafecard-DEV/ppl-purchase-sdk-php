<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use Exception;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Psr7;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function array_key_exists;
use function date;
use function gethostname;
use function gmdate;
use function implode;
use function in_array;
use function preg_match;
use function preg_quote;
use function preg_replace;
use function preg_replace_callback;
use function sprintf;
use function strpos;
use function substr;
use function trim;

class MessageAnonymizerFormatter extends MessageFormatter
{
    /**
     * @var array<string>
     */
    protected $bodyElements = [
        'purchase',
        'consumer',
    ];

    /**
     * @var array<string>
     */
    protected $headerElements = [
        'access_token',
        'Authorization',
        'paysafe-pl-secret-key',
    ];

    /**
     * @var string
     */
    protected $substitute;

    /**
     * @var string
     */
    protected $template;

    /**
     * @param string $template
     * @param string $substitute
     */
    public function __construct(string $template = self::DEBUG, string $substitute = '*****')
    {
        parent::__construct($template);

        $this->template = $template;
        $this->substitute = $substitute;
    }

    // phpcs:disable Generic.Metrics.CyclomaticComplexity.MaxExceeded
    // phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff

    /**
     * @inheritDoc
     */
    public function format(
        RequestInterface $request,
        ResponseInterface $response = null,
        Exception $error = null
    ): string {
        $cache = [];

        return (string) preg_replace_callback(
            '/{\s*([A-Za-z_\-.0-9]+)\s*}/',
            function (array $matches) use ($request, $response, $error, &$cache): string {
                if (array_key_exists($matches[1], $cache)) {
                    return $cache[$matches[1]];
                }

                $result = '';
                switch ($matches[1]) {
                    case 'request':
                        $result = $this->anonymizeBody(Psr7\str($request));
                        break;
                    case 'response':
                        $result = $response instanceof ResponseInterface ?
                            $this->anonymizeBody(Psr7\str($response)) :
                            '';
                        break;
                    case 'req_headers':
                        $result = sprintf(
                            "%s HTTP/%s\r\n%s",
                            trim($request->getMethod() . ' ' . $request->getRequestTarget()),
                            $request->getProtocolVersion(),
                            $this->anonymizeHeaders($request)
                        );
                        break;
                    case 'res_headers':
                        $result = $response instanceof ResponseInterface ?
                            sprintf(
                                "HTTP/%s %d %s\r\n%s",
                                $response->getProtocolVersion(),
                                $response->getStatusCode(),
                                $response->getReasonPhrase(),
                                $this->anonymizeHeaders($response)
                            ) : 'NULL';
                        break;
                    case 'req_body':
                        $result = $request->getBody();
                        break;
                    case 'res_body':
                        $result = $response instanceof ResponseInterface ? $response->getBody() : 'NULL';
                        break;
                    case 'ts':
                    case 'date_iso_8601':
                        $result = gmdate('c');
                        break;
                    case 'date_common_log':
                        $result = date('d/M/Y:H:i:s O');
                        break;
                    case 'method':
                        $result = $request->getMethod();
                        break;
                    case 'req_version':
                    case 'version':
                        $result = $request->getProtocolVersion();
                        break;
                    case 'uri':
                    case 'url':
                        $result = $request->getUri();
                        break;
                    case 'target':
                        $result = $request->getRequestTarget();
                        break;
                    case 'res_version':
                        $result = $response instanceof ResponseInterface
                            ? $response->getProtocolVersion()
                            : 'NULL';
                        break;
                    case 'host':
                        $result = $request->getHeaderLine('Host');
                        break;
                    case 'hostname':
                        $result = gethostname();
                        break;
                    case 'code':
                        $result = $response instanceof ResponseInterface ?
                            (string) $response->getStatusCode() :
                            'NULL';
                        break;
                    case 'phrase':
                        $result = $response instanceof ResponseInterface ?
                            $response->getReasonPhrase() :
                            'NULL';
                        break;
                    case 'error':
                        $result = $error instanceof Exception ? $error->getMessage() : 'NULL';
                        break;
                    default:
                        // handle prefixed dynamic headers
                        if (strpos($matches[1], 'req_header_') === 0) {
                            $result = $request->getHeaderLine(substr($matches[1], 11));
                        } elseif (strpos($matches[1], 'res_header_') === 0) {
                            $result = $response instanceof ResponseInterface
                                ? $response->getHeaderLine(substr($matches[1], 11))
                                : 'NULL';
                        }
                }

                $cache[$matches[1]] = (string) $result;
                return $cache[$matches[1]];
            },
            $this->template
        );
    }

    /**
     * @param string $content
     * @return string
     */
    public function anonymizeBody(string $content): string
    {
        // Anonymize the content body
        foreach ($this->bodyElements as $field) {
            $regexObject = sprintf(
                // phpcs:ignore SlevomatCodingStandard.Files.LineLength.LineTooLong
                '/"%s":(\{(?:(?>[^{}"\'\/]+)|(?>"(?:(?>[^\\"]+)|\\.)*")|(?>\'(?:(?>[^\\\']+)|\\.)*\')|(?>\/\/.*\n)|(?>\/\*.*?\*\/)|(?-1))*\})/',
                preg_quote($field, '/')
            );
            if (preg_match($regexObject, (string) $content) === 1) {
                $content = preg_replace(
                    $regexObject,
                    sprintf('"%s":{%s}', $field, $this->substitute),
                    (string) $content
                );
            } else {
                $regexValue = sprintf('/\"%s\":(.*?)\".*?\"/s', preg_quote($field, '/'));
                $content = preg_replace(
                    $regexValue,
                    sprintf('"%s":$1"%s"', $field, $this->substitute),
                    (string) $content
                );
            }
        }

        // Anonymize the content headers
        foreach ($this->headerElements as $field) {
            $regex = sprintf("/^%s: .*?\r\n/m", preg_quote($field, '/'));
            $content = preg_replace($regex, sprintf("%s: %s\r\n", $field, $this->substitute), (string) $content);
        }

        return (string) $content;
    }

    // phpcs:enable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
    // phpcs:enable Generic.Metrics.CyclomaticComplexity.MaxExceeded

    /**
     * @param MessageInterface $message
     * @return string
     */
    protected function anonymizeHeaders(MessageInterface $message): string
    {
        $result = '';
        foreach ($message->getHeaders() as $name => $values) {
            if (in_array($name, $this->headerElements, true)) {
                $values = [$this->substitute];
            }
            $result .= sprintf("%s: %s\r\n", $name, implode(', ', $values));
        }
        return trim($result);
    }
}
