<?php

namespace Olla\Prisma\Factory;
use Olla\Prisma\Values\Operation as OperationValue;

final class Operation implements FactoryInterface {
	public function create(array $annt = [], array $options = []):OperationValue {
		$op = new OperationValue($annt);
		return $op;
	}
}
