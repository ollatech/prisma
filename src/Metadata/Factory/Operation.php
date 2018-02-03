<?php

namespace Olla\Prisma\Metadata\Factory;

final class Operation implements FactoryInterface {
	public function create(array $annotation = [], array $payload = []) {
		$data = [];
		$data += $annotation;
		
		return $data;
	}
	
}
