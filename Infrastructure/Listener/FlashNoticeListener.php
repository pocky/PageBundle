<?php

namespace Black\Bundle\PageBundle\Infrastructure\Listener;

use Black\Component\Page\WebPageDomainEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class FlashNoticeListener
 */
class FlashNoticeListener implements EventSubscriberInterface
{
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var array
     */
    protected static $successMessages = [
        WebPageDomainEvents::WEBPAGE_DOMAIN_CREATED => 'black_page.flash.success.created',
        WebPageDomainEvents::WEBPAGE_DOMAIN_DEPUBLISHED => 'black_page.flash.success.depublished',
        WebPageDomainEvents::WEBPAGE_DOMAIN_PUBLISHED => 'black_page.flash.success.published',
        WebPageDomainEvents::WEBPAGE_DOMAIN_REMOVED => 'black_page.flash.success.removed',
        WebPageDomainEvents::WEBPAGE_DOMAIN_WRITE => 'black_page.flash.success.write',
    ];

    /**
     * @param Session $session
     * @param TranslatorInterface $translator
     */
    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            WebPageDomainEvents::WEBPAGE_DOMAIN_CREATED => 'addSuccessFlash',
            WebPageDomainEvents::WEBPAGE_DOMAIN_DEPUBLISHED => 'addSuccessFlash',
            WebPageDomainEvents::WEBPAGE_DOMAIN_PUBLISHED => 'addSuccessFlash',
            WebPageDomainEvents::WEBPAGE_DOMAIN_REMOVED => 'addSuccessFlash',
            WebPageDomainEvents::WEBPAGE_DOMAIN_WRITE => 'addSuccessFlash',
        ];
    }

    /**
     * @param Event $event
     */
    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }
        $this->session->getFlashBag()->add('success', $this->trans(self::$successMessages[$event->getName()]));
    }

    /**
     * @param $message
     * @param array $params
     * @return string
     */
    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'flash');
    }
}
