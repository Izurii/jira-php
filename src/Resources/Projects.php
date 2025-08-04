<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\Exceptions\ErrorException;
use Jira\Exceptions\TransporterException;
use Jira\Exceptions\UnserializableResponse;
use Jira\ValueObjects\Transporter\Payload;

class Projects
{
	use Concerns\Transportable;

	/**
	 * Create an issue or a sub-task from a JSON representation.
	 *
	 * @see https://developer.atlassian.com/server/jira/platform/rest/v10007/api-group-project/#api-api-2-project-post
	 *
	 * @param non-empty-array<array-key, mixed> $body
	 *
	 * @return non-empty-array<array-key, mixed>
	 *
	 * @throws ErrorException
	 * @throws TransporterException
	 * @throws UnserializableResponse
	 * @throws \JsonException
	 */
	public function create(array $body): array
	{
		$payload = Payload::create(
			uri: 'api/2/project',
			method: Method::POST,
			body: $body,
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

	/**
	 * Returns all projects which are visible for the currently logged in user.
	 * If no user is logged in, it returns the list of projects that are visible
	 * when using anonymous access.
	 *
	 * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/project-getAllProjects
	 *
	 * @param array<array-key, mixed> $query
	 *
	 * @return non-empty-array<array-key, mixed>
	 *
	 * @throws ErrorException
	 * @throws TransporterException
	 * @throws UnserializableResponse
	 * @throws \JsonException
	 */
	public function getAll(array $query = []): array
	{
		$payload = Payload::create(
			uri: 'api/2/project',
			query: $query,
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

	/**
	 * Contains a full representation of a project in JSON format.
	 *
	 * All project keys associated with the project will only be returned if expand=projectKeys.
	 *
	 * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/project-getProject
	 *
	 * @param array<array-key, mixed> $query
	 *
	 * @return non-empty-array<array-key, mixed>
	 *
	 * @throws ErrorException
	 * @throws TransporterException
	 * @throws UnserializableResponse
	 * @throws \JsonException
	 */
	public function get(int|string $id, array $query = []): array
	{
		$payload = Payload::create(
			uri: "api/2/project/{$id}",
			query: $query,
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

	public function getRoles(int|string $id)
	{
		$payload = Payload::create(
			uri: "api/2/project/{$id}/role",
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

	public function addDeveloperToProject(int|string $id, array $body)
	{
		$payload = Payload::create(
			uri: "api/2/project/{$id}/role/10802",
			method: Method::POST,
			body: $body,
		);

		// @phpstan-ignore-next-line
		return $this->transporter->request(payload: $payload);
	}

}
