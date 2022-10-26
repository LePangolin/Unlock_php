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
        $cardState = $this->em->getRepository(CardState::class)->findBy(['idGame' => $gameId]);
        $this->logger->info("CardStates for game {$gameId} found");
        return $cardState;
    }
}

?>