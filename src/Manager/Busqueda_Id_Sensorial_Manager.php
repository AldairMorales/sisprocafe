<?php

declare(strict_types=1);

namespace Pidia\Apps\Demo\Manager;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Busqueda_Id_Sensorial_Manager
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    public function por_ID(string $id): ?array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.apis.net.pe/v1/id?numero=' . $id
        );

        $statusCode = $response->getStatusCode();

        if (200 === $statusCode) {
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();
            // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
            return $content;
        }
        return null;
    }
}
