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
        $game = $this->findGameByUserId($userId);
        if($game === null) {
            $game = new Game($userId, $board, $score);
            $this->em->persist($game);
        } else {
            $game->setBoard($board);
            $game->setScore($score);
        }
    }

    public function findGameByUserId($userId)
    {
        return $this->em->find('AppBundle\Entity\Game', $userId);
    }

    public function findBoardByUserId($userId)
    {
        return $this->findGameByUserId($userId)->getBoard();
    }

    public function updateGameByUserId($userId, $board, $score)
    {
        $game = $this->findGameByUserId($userId);
        $game->setBoard($board);
        $game->setScore($score);
    }

    public function flush()
    {
        $this->em->flush();
    }
}
