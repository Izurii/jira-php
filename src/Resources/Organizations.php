<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\Exceptions\ErrorException;
use Jira\Exceptions\TransporterException;
use Jira\Exceptions\UnserializableResponse;
use Jira\ValueObjects\Transporter\Payload;

class Organizations
{
	use Concerns\Transportable;

	/**
	 * Create a organization.
	 *
	 * @see https://docs.atlassian.com/jira-servicedesk/REST/5.2.0/#servicedeskapi/customer-createCustomer
	 *
	 * @return non-empty-array<array-key, mixed>
	 *
	 * @throws ErrorException
	 * @throws TransporterException
	 * @throws UnserializableResponse
	 * @throws \JsonException
	 */
	public function create(string $name): array
	{
		$payload = Payload::create(
			uri: 'servicedeskapi/organization',
			method: Method::POST,
			body: [
				'name' => $name,
			],
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

	public function addUser(int $organizationId, string $accountId): null
	{
		$payload = Payload::create(
			uri: "servicedeskapi/organization/{$organizationId}/user",
			method: Method::POST,
			body: [
				'accountIds' => [$accountId],
			],
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

	/**
	 * @return array{organizationsCreated:array,organizationsAdded:array}
	 */
	public function addOrganizationToProject(int $organizationId, int $projectId): array
	{
		$payload = Payload::create(
			uri: "servicedesk/1/servicedesk/{$projectId}/organisation/invite",
			method: Method::PUT,
			body: [
				'existingOrganisationIds' => [$organizationId],
				'newOrganisationNames' => [],
			],
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}
}
