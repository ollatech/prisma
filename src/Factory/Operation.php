<?php

namespace Olla\Prisma\Factory;
use Olla\Prisma\Values\Operation as OperationValue;

final class Operation implements FactoryInterface {
	public function create(array $annt = [], array $options = []):OperationValue {
		$op = new OperationValue();
		$op->setId($annt['id']);
		$op->setDescription($annt['description']);
		$op->setTags($annt['tags']);
		$op->setParameters($annt['arguments']);
		$op->setRoute($annt['route']);
		$op->setAction($annt['action']);
		$op->setResource($annt['resource']);
		$op->setController($annt['controller']);
		return $op;
	}
}
