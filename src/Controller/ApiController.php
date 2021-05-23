<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Meme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }

    
    /**
     * get all data from api
     * @Route("/api/all", name="api_all")
     */
    public function apiAll()
    {
        $data = [
            'error' => 'null',
            'message' => 'null',
            'meme' => null
        ];

        $meme = $this->entityManager->getRepository(Meme::class)->findAll();

        if (count($meme) == 0) {
            $data['error'] = 'no data received';
        }else{
            foreach ($meme as $key => $value) {
                $data['meme'][$key]['name'] = $value->getName();
                $data['meme'][$key]['slug'] = $value->getSlug();
                $data['meme'][$key]['history'] = $value->getHistory();
                $data['meme'][$key]['picture'] = $_ENV['PICTURE_URL'].$value->getPicture();
            }
            $data['message'] = 'data successfully received';
        }

        return new JsonResponse($data);
    }


    /**
     * get all data by category 
     * @Route("/api/category/{category}", name="api_by_category")
     */
    public function apiAllByCategory($category)
    {
        $data = [
            'error' => 'null',
            'message' => 'null',
            'meme' => null
        ];

        // get id for the category
        $memeByCategory = $this->entityManager->getRepository(Category::class)->findOneBy([
            'name' => $category
        ])
            ->getMemes()
            ->toArray();

  

        if (count($memeByCategory) == 0) {
            $data['error'] = 'no data received';
        }else{
            foreach ($memeByCategory as $key => $value) {
                $data['meme'][$key]['name'] = $value->getName();
                $data['meme'][$key]['slug'] = $value->getSlug();
                $data['meme'][$key]['history'] = $value->getHistory();
                $data['meme'][$key]['picture'] = $_ENV['PICTURE_URL'].$value->getPicture();
            }
            $data['message'] = 'data successfully received';
        }

        return new JsonResponse($data);
    }


    /**
     * get random meme 
     * @Route("/api/random", name="api_random")
     */
    public function apiRandom()
    {
        $data = [
            'error' => 'null',
            'message' => 'null',
            'meme' => null
        ];

        $arrayMemes = $this->entityManager->getRepository(Meme::class)->findAll();
        $randomMeme = $arrayMemes[array_rand($arrayMemes)];


        if (count($arrayMemes) == 0) {
            $data['error'] = 'no data received';
        }else{
           
            $data['meme']['name'] = $randomMeme->getName();
            $data['meme']['slug'] = $randomMeme->getSlug();
            $data['meme']['history'] = $randomMeme->getHistory();
            $data['meme']['picture'] = $_ENV['PICTURE_URL'].$randomMeme->getPicture();
            
            $data['message'] = 'data successfully received';
        }

        return new JsonResponse($data);
    }
}
