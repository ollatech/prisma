<?php
namespace Olla\Prisma;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OllaPrismaBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		
	}
}
