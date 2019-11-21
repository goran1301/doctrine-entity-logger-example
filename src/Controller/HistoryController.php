<?php


namespace App\Controller;

use App\Entity\History;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/history")
 */
class HistoryController extends AbstractController
{
    /**
     * @Route("/list", name="history_index", methods={"GET"})
     */
    public function index(): Response
    {
        $history = $this->getDoctrine()
            ->getRepository(History::class)
            ->findAll();
        return $this->render('history/index.html.twig', [
            'history' => $history
        ]);
    }
}