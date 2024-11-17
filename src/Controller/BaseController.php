<?php declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseController extends AbstractController
{
    public function __construct(
        protected readonly EntityManagerInterface $doctrine,
        protected readonly ParameterBagInterface $parameterBag,
        protected readonly RequestStack $requestStack
    ) {
    }
}