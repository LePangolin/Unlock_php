<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\Game;
use Psr\Log\LoggerInterface;
use App\Services\CardStateService;
use App\Services\CardService;

final class GameService
{
    private EntityManager $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function getGame(int $gameId, CardStateService $cardStateService, CardService $cardService)
    {
        $game = $this->em->getRepository(Game::class)->findOneBy(['id' => $gameId]);

        if ($game) {
            $cardStates = $cardStateService->getCardStates($gameId);

            $cards = [];
            foreach ($cardStates as $cardState) {
                $card = $cardService->getCard($cardState->getIdCard());
                $cards[] = $card;
            }

            $finalTable = [];
            foreach ($cards as $card) {
                foreach ($cardStates as $cardState) {
                    if ($card->getId() == $cardState->getIdCard()) {
                        $finalTable[] = [
                            'id' => $card->getId(),
                            'path_to_recto' => $card->getPathToRecto(),
                            'path_to_verso' => $card->getPathToVerso(),
                            'state' => $cardState->getIdState(),
                            'deck_id' => $card->getDeckId()
                        ];
                    }
                }
            }

            $this->logger->info("Game {$gameId} found");

            return $finalTable;
        }

        $this->logger->error("Game {$gameId} not found");
        return null;
    }

    public function createGame(int $idPlayer, string $deckId, CardStateService $cardStateService, CardService $cardService)
    {
        try {
            $game = new Game($idPlayer, $deckId);
            $this->em->persist($game);
            $this->em->flush();
            $this->logger->info("Game {$game->getId()} created");
            $cardStateService->createCarteStates($game->getId(), $deckId, $cardService);
            return $game->getId();
        } catch(\Exception $e) {
            $this->logger->error("Game not created : " . $e->getMessage());
            $this->em->flush();
            return null;
        }
    }
}
