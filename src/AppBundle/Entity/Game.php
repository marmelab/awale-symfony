<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\GameRepository")
 * @ORM\Table
 */
class Game
{
    /**
     * @ORM\Column(type="string", name="user_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @ORM\Column(type="json_array")
     */
    private $board;

    /**
     * @ORM\Column(type="json_array")
     */
    private $score;

    public function __construct($userId, $board, $score)
    {
        $this->userId = $userId;
        $this->board = $board;
        $this->score = $score;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set board
     *
     * @param array $board
     *
     * @return Game
     */
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }

    /**
     * Get board
     *
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Set score
     *
     * @param array $score
     *
     * @return Game
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return array
     */
    public function getScore()
    {
        return $this->score;
    }
}
