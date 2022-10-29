<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\Game;
use Psr\Log\LoggerInterface;
use App\Services\CardStateService;
use App\Services\CardService;
use App\Helper\Enum;

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
        /* On récupère la partie */
        $game = $this->em->getRepository(Game::class)->findOneBy(['id' => $gameId]);

        /* Si la partie existe */
        if ($game) {

            /* On récupère les cartes de la partie */
            $cardStates = $cardStateService->getCardStates($gameId);

            /* On crée un tableau qui contient 3 tableaux, correspondant aux positions en jeu */
            $finalTable = [];
            $drawPile = [];
            $discardPile = [];
            $gameboard = [];

            /* On récupère les données fixes des cartes qu'on associe aux données spécifiques de la carte dans la partie */
            foreach ($cardStates as $cardState) {
                $card = $cardService->getCard($cardState->getIdCard());
                $cardData =  [
                    'id' => $card->getId(),
                    'idState' => $cardState->getIdState(),
                    'path_to_verso' => $card->getPathToVerso(),
                    'path_to_recto' => $card->getPathToRecto(),
                ];
                /* Placement de la carte dans le tableau correspondant a sa position */
                switch ($cardState->getIdState()) {
                    case Enum::DRAW:
                        $drawPile[] = $cardData;
                        break;
                    case Enum::DISCARD:
                        $discardPile[] = $cardData;
                        break;
                    case Enum::PLAY:
                        $gameboard[] = $cardData;
                        break;
                }
            }
            $this->logger->info("Game {$gameId} found");

            /* On ajoute les tableaux de cartes dans un tableau */
            array_push($finalTable, $drawPile, $discardPile, $gameboard);

            /* On retourne ce dernier */
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
        } catch (\Exception $e) {
            $this->logger->error("Game not created : " . $e->getMessage());
            $this->em->flush();
            return null;
        }
    }
}
