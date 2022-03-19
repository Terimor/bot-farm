<?php

namespace App\ProviderFacade\VK\Decorator;

use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiAccessGroupsException;
use VK\Exceptions\Api\VKApiBlockedException;
use VK\Exceptions\Api\VKApiWallAccessAddReplyException;
use VK\Exceptions\Api\VKApiWallAccessRepliesException;
use VK\Exceptions\Api\VKApiWallLinksForbiddenException;
use VK\Exceptions\Api\VKApiWallReplyOwnerFloodException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class VKApiClientDecorator
{
    private VKApiClient $client;
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->client = new VKApiClient();
        $this->accessToken = $accessToken;
    }

    /**
     * @return int[]
     * @throws VKApiAccessGroupsException
     * @throws VKApiException
     * @throws VKClientException
     */
    public function getGroupIds(): array
    {
        $response = $this->client->groups()->get($this->accessToken);

        return $response['items'];
    }

    /**
     * @throws VKApiBlockedException
     * @throws VKApiException
     * @throws VKClientException
     */
    public function getWallForGroup(int $groupId): array
    {
        $response = $this->client->wall()->get($this->accessToken, [
            'owner_id' => "-{$groupId}",
        ]);

        return $response['items'];
    }

    /**
     * @throws VKApiException
     * @throws VKApiWallAccessAddReplyException
     * @throws VKApiWallReplyOwnerFloodException
     * @throws VKClientException
     * @throws VKApiWallLinksForbiddenException
     * @throws VKApiWallAccessRepliesException
     */
    public function sendComment(int $postId, string $ownerId, string $comment): void
    {
        $this->client->wall()->createComment(
            $this->accessToken,
            ['post_id' => $postId, 'owner_id' => $ownerId, 'message' => $comment]
        );
    }
}