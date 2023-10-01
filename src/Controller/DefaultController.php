<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __construct(
        private BookRepository $bookRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/newBook/{title}', name: 'newBoot', methods: ['GET'])]
    public function newBook(string $title): Response
    {
        $book = (new Book())->setTitle($title);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->redirectToRoute('root');
    }

    #[Route(path: '/', name: 'root', methods: ['GET'])]
    public function root(): Response
    {
        $books = $this->bookRepository->findAll();

        return $this->json([
            'books' => $books,
        ]);
    }
}
