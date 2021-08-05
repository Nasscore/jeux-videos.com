<?php

namespace App\Twig;


use App\Entity\Game;
use App\Repository\ForumRepository;
use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FiltreFunctionExtension extends AbstractExtension
{
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var PostRepository
     */
    private $postRepository;
    /**
     * @var GameRepository
     */
    private $gameRepository;
    /**
     * @var Environment
     */
    private $twigEnvironment;

    /**
     * FiltreFunctionExtension constructor.
     * @param ForumRepository $forumRepository
     * @param PostRepository $postRepository
     * @param GameRepository $gameRepository
     * @param Environment $twigEnvironment
     */
    public function __construct(ForumRepository $forumRepository, PostRepository $postRepository, GameRepository $gameRepository, Environment $twigEnvironment)
    {
        $this->forumRepository = $forumRepository;
        $this->postRepository = $postRepository;
        $this->gameRepository = $gameRepository;
        $this->twigEnvironment = $twigEnvironment;
    }


    public function getFilters()
    {
        return[
//            new TwigFilter('first_letter_uppercase',[$this,'firstLetterUppercase'])


        ];
    }
    public function getFunctions(){
        return[
            new TwigFunction('star_display',[$this,'starDisplay']),
            new TwigFunction('count_game',[$this,'countGame']),
            new TwigFunction('count_article',[$this,'countPost']),
            new TwigFunction('getAllForums',[$this,'getAllForums']),


        ];
    }
    public function starDisplay(Game $game){
      return $this->twigEnvironment->render('component/displayStarGame.html.twig',[
          'game'=>$game
      ]);
    }
    public function countGame(){

        return count($this->gameRepository->findAll());
    }
    public function countPost(){

        return count($this->postRepository->findAll());
    }
    public function getAllForums(){

        return $this->forumRepository->findAll();
    }

}