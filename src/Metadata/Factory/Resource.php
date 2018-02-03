<?php

namespace Olla\Prisma\Metadata\Factory;

final class Resource implements FactoryInterface  {
	
	public function create(array $annotation = [], array $payload = []) {
		$data = [];
		if(isset($annotation['class'])) {
			$data['class'] = $annotation['class'];
		}
		if(isset($annotation['alias'])) {
			$data['alias'] = $annotation['alias'];
		}
		if(isset($annotation['type'])) {
			$data['type'] = $annotation['type'];
		}
		if(!isset($data['id'])) {
			$data['id'] = $annotation['alias'];
		}
		return $data;
	}
}
