<?php
namespace Olla\Prisma;

use Olla\Operation\Resolver;
use Symfony\Component\HttpFoundation\RequestStack;

final class Controller
{
    protected $requestStack;
    protected $operation;
    public function __construct(RequestStack $requestStack, Resolver $operation) {
        $this->requestStack = $requestStack;
        $this->operation = $operation;
    }

    public function __invoke() {
        $request = $this->getRequest();
        if(null === $operationId = $request->attributes->get('_operation')) {
            throw new Exception("Error Processing Request", 1);
        }
        if(null === $carrier = $request->attributes->get('_carrier')) {
            throw new Exception("Error Processing Request", 1);
        }
        $args = $this->args();
        return $this->operation->resolve($args, $request);
    }

    protected function args() {
        $request = $this->getRequest();
        $args = [];
        if(null !== $operationId = $request->attributes->get('_operation')) {
            $args['operation_id'] = $operationId;
        }
        if(null !== $carrier = $request->attributes->get('_carrier')) {
            $args['carrier'] = $carrier;
        }
        if(null !== $format = $request->attributes->get('_format')) {
            $args['format'] = $format;
        }
        if(null !== $parameters = $request->attributes->get('_parameters')) {
            $args['parameters'] = $parameters;
        }
        return $args;
    }
    protected function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }
}
