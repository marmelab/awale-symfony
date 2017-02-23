<?php

namespace AppBundle\Entity;

class GameRepository extends \Doctrine\ORM\EntityRepository
{

    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function addNewGame($userId, $board, $score)
    {
        $game = new Game($userId, $board, $score);
        $this->em->persist($game);
    }

    public function findGameByUserId($userId)
    {
        return $this->em->find('AppBundle\Entity\Game', $userId);
    }

    public function flush()
    {
        $this->em->flush();
    }
}
