<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Util\Paginator;
use Pidia\Apps\Demo\Form\AcopioType;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Entity\PagoAcopio;
use Pidia\Apps\Demo\Form\PagoAcopioType;
use Pidia\Apps\Demo\Entity\AnalisisFisico;
use Pidia\Apps\Demo\Form\ModifiAcopioType;
use Symfony\Component\HttpFoundation\Request;
use Pidia\Apps\Demo\Manager\PagoAcopioManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pidia\Apps\Demo\Manager\AnalisisFisicoManager;

#[Route('/admin/pago/acopio')]
class PagoAcopioController extends BaseController
{
    #[Route(path: '/', name: 'pagoAcopio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'pagoAcopio_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, PagoAcopioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'pagoAcopio_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'pagoAcopio/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'pagoAcopio_export', methods: ['GET'])]
    public function export(Request $request, PagoAcopioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'pagoAcopio_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alisas',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var pagoAcopio $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'pagoAcopio');
    }

    #[Route(path: '/new', name: 'pagoAcopio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ?Acopio $acopio, PagoAcopioManager $manager, AnalisisFisicoManager $FisicoManager): Response
    {
        $this->denyAccess(Access::EDIT, 'acopio_index');
        $this->denyAccess(Access::NEW, 'pagoAcopio_index');
        $pagoAcopio = new pagoAcopio();
        //$acopio = $manager->repositorio()->filter(['id' => 5]);
        $entityManager = $manager->manager();
        $acopio = $entityManager->getRepository(Acopio::class)->find(4);
        $form = $this->createForm(PagoAcopioType::class, $pagoAcopio);
        $form1 = $this->createForm(ModifiAcopioType::class, $acopio);
        $analisisFisico = $FisicoManager->manager()->getRepository(AnalisisFisico::class)->find($acopio->getId());
        $form1->handleRequest($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pagoAcopio->setAcopio($acopio);
            $pagoAcopio->setPropietario($this->getUser());
            if ($manager->save($pagoAcopio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }
            return $this->redirectToRoute('pagoAcopio_index');
        }
        return $this->render(
            'pagoAcopio/new.html.twig',
            [
                'pagoAcopio' => $pagoAcopio,
                'form1' => $form1->createView(),
                'form' => $form->createView()
            ]
        );
    }

    #[Route(path: '/{id}', name: 'pagoAcopio_show', methods: ['GET'])]
    public function show(PagoAcopio $pagoAcopio): Response
    {
        $this->denyAccess(Access::VIEW, 'pagoAcopio_index');

        return $this->render('pagoAcopio/show.html.twig', ['pagoAcopio' => $pagoAcopio]);
    }

    #[Route(path: '/{id}/edit', name: 'pagoAcopio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PagoAcopio $pagoAcopio, PagoAcopioManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'pagoAcopio_index');
        $form = $this->createForm(PagoAcopioType::class, $pagoAcopio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($pagoAcopio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('pagoAcopio_index', ['id' => $pagoAcopio->getId()]);
        }

        return $this->render(
            'pagoAcopio/edit.html.twig',
            [
                'pagoAcopio' => $pagoAcopio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'pagoAcopio_delete', methods: ['POST'])]
    public function delete(Request $request, PagoAcopio $pagoAcopio, PagoAcopioManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'pagoAcopio_index');
        if ($this->isCsrfTokenValid('delete' . $pagoAcopio->getId(), $request->request->get('_token'))) {
            $pagoAcopio->changeActivo();
            if ($manager->save($pagoAcopio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('pagoAcopio_index');
    }

    #[Route(path: '/{id}/delete', name: 'pagoAcopio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, PagoAcopio $pagoAcopio, PagoAcopioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'pagoAcopio_index', $pagoAcopio);
        if ($this->isCsrfTokenValid('delete_forever' . $pagoAcopio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($pagoAcopio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('pagoAcopio_index');
    }
}
