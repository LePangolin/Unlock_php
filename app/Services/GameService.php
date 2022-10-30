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
                $card = $cardService->getCard($cardState->getIdCard(), $cardState->getIdDeck());
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

    public function save(CardStateService $cardStateService, CardService $cardService)
    {
        try {
            // récupérer les différents tas de cartes
            $drawPile = json_decode($_POST['draw_pile'], true);
            $discardPile = json_decode($_POST['discard_pile'], true);
            $gameboardPile = json_decode($_POST['gameboard_pile'], true);

            $draw = [];
            $discard = [];
            $gameboard = [];

            // en faire des tableau d'id 
            foreach($drawPile as $a) {
                array_push($draw, $a['id']);
            }
            foreach($discardPile as $a) {
                array_push($discard, $a['id']);
            }
            foreach($gameboardPile as $a) {
                array_push($gameboard, $a['id']);
            }

            //récupérer les états des cartes de la base de données 
            $cardsState = $cardStateService->getCardStates($_POST['game_id']);
            
            // boucle sur les cartes pour changer state suivant dans quelle pile elles étaient
            foreach($cardsState as $card) {
                if (in_array($card->getIdCard(), $draw)) { // vérification si l'id de la carte appartient à la pioche 
                    $card->setIdState(2);
                } else if (in_array($card->getIdCard(), $discard)) { // vérification si l'id de la carte appartient à la défausse 
                    $card->setIdState(1);
                } else if (in_array($card->getIdCard(), $gameboard)) { // vérification si l'id de la carte appartient au plateau de jeu 
                    $card->setIdState(3);
                }

                $this->em->persist($card);
                $this->em->flush();
                $this->logger->info("Card {$card->getIdCard()} state updated");
            }
            return true;
        } catch(\Exception $e) {
            $this->logger->error("Game not saved : " . $e->getMessage());
            $this->em->flush();
            return false;
        }              
    }

    public function getGameIds() {
        try {
            $games = $this->em->getRepository(Game::class)->findBy(array('playerId' => $_SESSION['user']->getId()));
            $this->logger->info("DeckIds found");
            $gameIds = [];
            foreach($games as $game) {
                array_push($gameIds, array('id' => $game->getId(), 'deckId' => $game->getDeckId()));
            }
            return $gameIds;
        } catch (\Exception $e) {
            $this->logger->error("DeckIds not found : " . $e->getMessage());
            return [];
        }
    }

    public function endGame() {
        try {
            $game = $this->em->getRepository(Game::class)->findBy(array('playerId' => $_SESSION['user']->getId(), 'id' => $_POST['game_id']));
            $this->logger->info("game found");
            $this->em->remove($game[0]);
            $this->em->flush();
            $this->logger->info("game successfully deleted");
        } catch (\Exception $e) {
            $this->logger->error("Cannot delete this game : " . $e->getMessage());
        } 
    }
}
