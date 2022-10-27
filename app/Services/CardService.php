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
        return $card;
    }

    public function getCards()
    {
        $cards = $this->em->getRepository(Card::class)->findAll();
        return $cards;
    }

    public function getCardByDeckId($deckId)
    {
        $cards = $this->em->getRepository(Card::class)->findBy(['deck_id' => $deckId]);
        return $cards;
    }
}