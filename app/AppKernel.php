<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AGIL\DefaultBundle\AGILDefaultBundle(),
            new AGIL\ForumBundle\AGILForumBundle(),
            new AGIL\OfferBundle\AGILOfferBundle(),
            new AGIL\SearchBundle\AGILSearchBundle(),
            new AGIL\ChatBundle\AGILChatBundle(),
            new AGIL\HallBundle\AGILHallBundle(),
            new AGIL\AdminBundle\AGILAdminBundle(),
            new AGIL\ProfileBundle\AGILProfileBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new AGIL\UserBundle\AGILUserBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new Gos\Bundle\WebSocketBundle\GosWebSocketBundle(),
            new Gos\Bundle\PubSubRouterBundle\GosPubSubRouterBundle(),
            );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
