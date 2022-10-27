<?php

namespace App\Services;

use App\Models\Card;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

final class CardService
{
    private EntityManager $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function getCard($id)
    {
        $card = $this->em->getRepository(Card::class)->findOneBy(['id' => $id]);
        $this->logger->info("Card {$id} found");
        return $card;
    }

    public function getCards()
    {
        $cards = $this->em->getRepository(Card::class)->findAll();
        $this->logger->info("Cards found");
        return $cards;
    }

    public function getCardByDeckId($deckId)
    {
        $cards = $this->em->getRepository(Card::class)->findBy(['deck_id' => $deckId]);
        $this->logger->info("Cards found for deck {$deckId}");
        return $cards;
    }
}