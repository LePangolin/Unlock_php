<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\Game;
use Psr\Log\LoggerInterface;
use App\Services\CardStateService;

final class GameService
{
    private EntityManager $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function getGame(int $gameId, CardStateService $cardStateService){
        
        $game = $this->em->getRepository(Game::class)->findOneBy(['id' => $gameId]);
        
        if ($game) {
            
            $cardStates = $cardStateService->getCardStates($gameId);

            $this->logger->info("Game {$gameId} found");

            return $cardStates;
        }

        $this->logger->error("Game {$gameId} not found");
        return null;
    }
}

?>