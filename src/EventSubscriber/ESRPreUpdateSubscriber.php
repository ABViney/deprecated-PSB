<?php

namespace App\EventSubscriber;

use App\Entity\Account;
use App\Entity\ESR;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ESRPreUpdateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
    )
    {}

    /**
     * Signs the document with the name of the employee
     * that's attached to the current account. If this
     * fails for whatever reason, a null value exception
     * will interrupt.
     */
    public function applySignature(ESR $esr): void
    {
        /** @var Account */
        $account = $this->security->getUser();
        $esr->setSignedBy($account->getAssignedTo());
    }

    public function onBeforePersistedHandler(BeforeEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();
        
        if ($entity instanceof ESR) {
            $this->applySignature($entity);
        }
    }

    public function onBeforeUpdatedHandler(BeforeEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();
        
        if ($entity instanceof ESR) {
            $this->applySignature($entity);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforePersistedHandler',
            BeforeEntityUpdatedEvent::class => 'onBeforeUpdatedHandler'
        ];
    }
}
