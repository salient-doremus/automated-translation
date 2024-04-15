<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\AutomatedTranslation\Client;

use GuzzleHttp\Client;
use Ibexa\AutomatedTranslation\Exception\ClientNotConfiguredException;
use Ibexa\AutomatedTranslation\Exception\InvalidLanguageCodeException;
use Ibexa\Contracts\AutomatedTranslation\Client\ClientInterface;

class Deepl implements ClientInterface
{
    private string $authKey;
    private string $host = 'https://api.deepl.com';
    private string $translateApi = '/v2/translate';

    public function getServiceAlias(): string
    {
        return 'deepl';
    }

    public function getServiceFullName(): string
    {
        return 'Deepl';
    }

    /**
     * @param array{authKey?: string} $configuration
     */
    public function setConfiguration(array $configuration): void
    {
        if (!isset($configuration['authKey'])) {
            throw new ClientNotConfiguredException('authKey is required');
        }
        $this->authKey = $configuration['authKey'];

        if (isset($configuration['host'])) {
            $this->host = $configuration['host'];
        }

        if (isset($configuration['translateApi'])) {
            $this->translateApi = $configuration['translateApi'];
        }
    }

    public function translate(string $payload, ?string $from, string $to): string
    {
        $parameters = [
            'auth_key' => $this->authKey,
            'target_lang' => $this->normalized($to),
            'tag_handling' => 'xml',
            'ignore_tags' => 'x',
            'text' => $payload,
        ];

        if (null !== $from) {
            $parameters += [
                'source_lang' => $this->normalized($from),
            ];
        }

        $http = new Client(
            [
                'base_uri' => $this->host,
                'timeout' => 5.0,
            ]
        );
        $response = $http->post($this->host.$this->translateApi, ['form_params' => $parameters]);
        // May use the native json method from guzzle
        $json = json_decode($response->getBody()->getContents());

        return $json->translations[0]->text;
    }

    public function supportsLanguage(string $languageCode): bool
    {
        return \in_array($this->normalized($languageCode), self::LANGUAGE_CODES);
    }

    private function normalized(string $languageCode): string
    {
        if (\in_array($languageCode, self::LANGUAGE_CODES)) {
            return $languageCode;
        }

        $code = strtoupper(substr($languageCode, 0, 2));
        if (\in_array($code, self::LANGUAGE_CODES)) {
            return $code;
        }

        throw new InvalidLanguageCodeException($languageCode, $this->getServiceAlias());
    }

    /**
     * See source_language parameter from https://developers.deepl.com/docs/api-reference/translate/openapi-spec-for-text-translation
     */
    private const LANGUAGE_CODES = ['BG','CS','DA','DE','EL','EN','ES','ET','FI','FR','HU','ID','IT','JA','KO','LT','LV','NB','NL','PL','PT','RO','RU','SK','SL','SV','TR','UK','ZH'];
}

class_alias(Deepl::class, 'EzSystems\EzPlatformAutomatedTranslation\Client\Deepl');
