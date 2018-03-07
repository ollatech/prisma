<?php
namespace Olla\Prisma\Bundle;

use Olla\Prisma\Bundle\Compiler\PathCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OllaPrismaBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new PathCompilerPass());
	}
}
