<?php


namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\CardState;
use Psr\Log\LoggerInterface;
use App\Helper\Enum;
use App\Models\Card;

final class CardStateService
{
    private EntityManager $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function getCardStates(int $gameId)
    {
        try {
            $cardStates = $this->em->getRepository(CardState::class)->findBy(['idGame' => $gameId]);
            $this->logger->info("CardStates for game {$gameId} found");
            return $cardStates;
        } catch (\Exception $e) {
            $this->logger->error("CardStates for game {$gameId} not found : " . $e->getMessage());
            return [];
        }
    }

    public function createCarteStates(int $gameId, string $deckId, CardService $cardService)
    {
        try {
            $cards = $cardService->getCardByDeckId($deckId);
            /* Certaines cartes sont déjà positionnées en début de partie */
            foreach ($cards as $card) {
                $position = Enum::DRAW;
                if ($card->getId() == Card::MAINCARD) {
                    $position = Enum::PLAY;
                } else if ($card->getId() == Card::DISCARD_DEFAULT) {
                    $position = Enum::DISCARD;
                }
                $cardState = new CardState($gameId, $card->getId(), $position, $card->getDeckId());
                $this->em->persist($cardState);
                $this->em->flush();
                $this->logger->info("CardStates for game {$gameId} created");
            }
        } catch (\Exception $e) {
            $this->logger->error("CardStates for game {$gameId} not created : " . $e->getMessage());
            $this->em->flush();
        }
    }
}
