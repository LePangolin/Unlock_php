<?php 


namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\CardState;
use Psr\Log\LoggerInterface;



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
        try{
            $cardStates = $this->em->getRepository(CardState::class)->findBy(['idGame' => $gameId]);
            $this->logger->info("CardStates for game {$gameId} found");
            return $cardStates;
        }
        catch(\Exception $e){
            $this->logger->error("CardStates for game {$gameId} not found : " . $e->getMessage());
            return [];
        }
    }

    public function createCarteStates(int $gameId, string $deckId, CardService $cardService)
    {
        try{
            $cards = $cardService->getCardByDeckId($deckId);
            foreach($cards as $card){
                $cardState = new CardState($gameId,$card->getId(),2,$card->getDeckId());
                $this->em->persist($cardState);
                $this->em->flush();
                $this->logger->info("CardStates for game {$gameId} created");
            }
        }catch(\Exception $e){
            $this->logger->error("CardStates for game {$gameId} not created : " . $e->getMessage());
            $this->em->flush();
        }
    }
}

?>