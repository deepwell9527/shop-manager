<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer;

use Deepwell\ChannelsShop\Api\Sharer\Request\BindRequest;
use Deepwell\ChannelsShop\Api\Sharer\Request\GetSharerListRequest;
use Deepwell\ChannelsShop\Api\Sharer\Response\SharerBindResponse;
use Deepwell\ChannelsShop\Api\Sharer\Response\SharerListResponse;
use Deepwell\ChannelsShop\Contracts\AbstractApiClient;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use const JSON_BIGINT_AS_STRING;
use const JSON_THROW_ON_ERROR;

class Client extends AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    /**
     * 邀请小店普通分享员
     * @param BindRequest $req
     * @return SharerBindResponse
     * @throws JsonException
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function bind(BindRequest $req): SharerBindResponse
    {
        $res = $this->client->postJson('/channels/ec/sharer/bind', $req->toArray());
        try {
            $content = json_decode($res->getContent(), true, 512, JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (\JsonException $e) {
            throw new JsonException($e->getMessage() . sprintf(' for "%s".', $res->getInfo('url')), $e->getCode());
        }
        return SharerBindResponse::from($content);
    }

    public function getList(GetSharerListRequest $req): SharerListResponse
    {
        $res = $this->client->postJson('/channels/ec/sharer/get_sharer_list', $req->toArray());
        return SharerListResponse::from($res);
    }
}