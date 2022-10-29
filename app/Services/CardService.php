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

    public function getCard($id, string $deckId)
    {
        try {
            $card = $this->em->getRepository(Card::class)->findOneBy(['id' => $id,"deckId" => $deckId]);
            $this->logger->info("Card {$id} found");
            return $card;
        } catch (\Exception $e) {
            $this->logger->error("Card {$id} not found : " . $e->getMessage());
            return [];
        }
    }

    public function getCards()
    {
        try {
            $cards = $this->em->getRepository(Card::class)->findAll();
            $this->logger->info("Cards found");
            return $cards;
        } catch (\Exception $e) {
            $this->logger->error("Cards not found : " . $e->getMessage());
            return [];
        }
    }

    public function getCardByDeckId($deckId)
    {
        try {
            $cards = $this->em->getRepository(Card::class)->findBy(['deckId' => $deckId]);
            $this->logger->info("Cards for deck {$deckId} found");
            return $cards;
        } catch (\Exception $e) {
            $this->logger->error("Cards for deck {$deckId} not found : " . $e->getMessage());
            return [];
        }
    }
}
