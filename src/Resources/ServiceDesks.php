<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\Transporter\Payload;

class ServiceDesks
{
	use Concerns\Transportable;

	public function getRequestTypeGroups(int|string $serviceDeskId)
	{

		$payload = Payload::create(
			uri: "servicedeskapi/servicedesk/{$serviceDeskId}/requesttypegroup",
			method: Method::GET,
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);

	}

	public function getRequestTypeFields(int|string $serviceDeskId, int|string $requestTypeId): array
	{
		$payload = Payload::create(
			uri: "servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field",
			method: Method::GET,
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

}
