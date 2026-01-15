<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    #[Route('/', name: 'app_pizza_index', methods: ['GET', 'POST'])]
    public function index(Request $request, PizzaRepository $repository, EntityManagerInterface $em): Response
    {
        $pizza = new Pizza();
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        $error = null;
        $success = null;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $repository->add($pizza);
                $em->flush();
                $this->addFlash('success', 'Pizza ajoutée avec succès');

                return $this->redirectToRoute('app_pizza_index');
            } catch (UniqueConstraintViolationException $exception) {
                $error = 'Cet ingrédient secret est déjà utilisé par une autre pizza.';
            }
        }

        $pizzas = $repository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pizza/index.html.twig', [
            'form' => $form,
            'pizzas' => $pizzas,
            'error' => $error,
            'success' => $success,
        ]);
    }

    #[Route('/pizza/{id}/edit', name: 'app_pizza_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pizza $pizza, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('success', 'Pizza modifiée avec succès');
                return $this->redirectToRoute('app_pizza_index');
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('error', 'Cet ingrédient secret est déjà utilisé par une autre pizza.');
            }
        }

        return $this->render('pizza/edit.html.twig', [
            'form' => $form,
            'pizza' => $pizza,
        ]);
    }

    #[Route('/pizza/{id}/delete', name: 'app_pizza_delete', methods: ['POST'])]
    public function delete(Request $request, Pizza $pizza, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pizza->getId(), $request->request->get('_token'))) {
            $em->remove($pizza);
            $em->flush();
            $this->addFlash('success', 'Pizza supprimée avec succès');
        }

        return $this->redirectToRoute('app_pizza_index');
    }
}
