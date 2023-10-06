<?php

namespace App\EventSubscriber;

use App\Entity\JobOffer;
use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\Client;
use App\Entity\User;
use App\Entity\Notes;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminSubscriber implements EventSubscriberInterface {
    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }
    public static function getSubscribedEvents(){
        return [
            BeforeEntityPersistedEvent::class => ['setCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['hashPassword'],
            BeforeEntityUpdatedEvent::class => ['setUpdatedAt'],
            BeforeEntityDeletedEvent::class => ['deleteNotes'],
            BeforeEntityUpdatedEvent::class => ['updateNotes'],
        ];
    }

    public function setCreatedAt(BeforeEntityPersistedEvent $event){
        $entityInstance = $event->getEntityInstance();
        if(!$entityInstance instanceof JobOffer && !$entityInstance instanceof Application && !$entityInstance instanceof Candidate) {
            return;
        }
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
    }

    public function hashPassword(BeforeEntityUpdatedEvent $event){
        $entityInstance = $event->getEntityInstance();
        if(!$entityInstance instanceof User) {
            return;
        }
        
        $hashedPassword = $this->passwordHasher->hashPassword(
            $entityInstance,
            $entityInstance->getPassword()
        );
        $entityInstance->setPassword($hashedPassword);
    }
    public function setUpdatedAt(BeforeEntityUpdatedEvent $event){
        $entityInstance = $event->getEntityInstance();
        if(!$entityInstance instanceof Candidate) {
            return;
        }
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
    }

    public function deleteNotes(BeforeEntityDeletedEvent $event){
        $entityInstance = $event->getEntityInstance();
        if(!$entityInstance instanceof Notes) {
            return;
        }
        if(null !== ($entityInstance->getCandidate())) {
        $candidate = $entityInstance->getCandidate();
        $candidate->setNotes(NULL);

        $this->entityManager->persist($candidate);
        $this->entityManager->flush();

        $entityInstance->setCandidate(null);
        $this->entityManager->persist($entityInstance);
        $this->entityManager->flush();
        }
        else if(null !== ($entityInstance->getClient())) {
        $client = $entityInstance->getClient();
        $client->setNotes(NULL);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $entityInstance->setClient(null);
        $this->entityManager->persist($entityInstance);
        $this->entityManager->flush();
        }
        else if(null !== ($entityInstance->getJobOffer())) {
            $jobOffer = $entityInstance->getJobOffer();
            $jobOffer->setNotes(NULL);
    
            $this->entityManager->persist($jobOffer);
            $this->entityManager->flush();
    
            $entityInstance->setJobOffer(null);
            $this->entityManager->persist($entityInstance);
            $this->entityManager->flush();
            }
    }
    public function updateNotes(BeforeEntityUpdatedEvent $event){
        $entityInstance = $event->getEntityInstance();
        if(!$entityInstance instanceof Client && !$entityInstance instanceof Candidate && !$entityInstance instanceof JobOffer) {
            return;
        }
        $notes = $entityInstance->getNotes();
        if($notes->getContent() == null && $notes !== null) {
        $entityInstance->setNotes(null);
        $this->entityManager->persist($entityInstance);
        $this->entityManager->flush();

        $this->entityManager->remove($notes);
        $this->entityManager->flush();
        }
    }

}
