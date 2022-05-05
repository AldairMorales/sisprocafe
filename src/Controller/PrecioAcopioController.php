<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\PrecioAcopio;
use Pidia\Apps\Demo\Form\PrecioAcopioType;
use Pidia\Apps\Demo\Manager\PrecioAcopioManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/precio/acopio')]
class PrecioAcopioController extends BaseController
{
    #[Route(path: '/', name: 'precioAcopio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'precioAcopio_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, PrecioAcopioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'precioAcopio_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'precioAcopio/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'precioAcopio_export', methods: ['GET'])]
    public function export(Request $request, PrecioAcopioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'precioAcopio_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alias',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var PrecioAcopio $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            // $item['nombre'] = $objeto->getNombre();
            // $item['alias'] = $objeto->getAlias();
            // $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/precio/new', name: 'precioAcopio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PrecioAcopioManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'precioAcopio_index');
        $precioAcopio = new PrecioAcopio();
        $form = $this->createForm(PrecioAcopioType::class, $precioAcopio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $precioAcopio->setPropietario($this->getUser());
            if ($manager->save($precioAcopio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('precioAcopio_index');
        }

        return $this->render(
            'precioAcopio/new.html.twig',
            [
                'precioAcopio' => $precioAcopio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'precioAcopio_show', methods: ['GET'])]
    public function show(PrecioAcopio $precioAcopio): Response
    {
        $this->denyAccess(Access::VIEW, 'precioAcopio_index');

        return $this->render('precioAcopio/show.html.twig', ['precioAcopio' => $precioAcopio]);
    }

    #[Route(path: '/{id}/edit', name: 'precioAcopio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PrecioAcopio $precioAcopio, PrecioAcopioManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'precioAcopio_index');
        $form = $this->createForm(PrecioAcopioType::class, $precioAcopio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($precioAcopio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('precioAcopio_index', ['id' => $precioAcopio->getId()]);
        }

        return $this->render(
            'precioAcopio/edit.html.twig',
            [
                'precioAcopio' => $precioAcopio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'precioAcopio_delete', methods: ['POST'])]
    public function delete(Request $request, PrecioAcopio $precioAcopio, PrecioAcopioManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'precioAcopio_index');
        if ($this->isCsrfTokenValid('delete' . $precioAcopio->getId(), $request->request->get('_token'))) {
            $precioAcopio->changeActivo();
            if ($manager->save($precioAcopio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('precioAcopio_index');
    }

    #[Route(path: '/{id}/delete', name: 'precioAcopio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, PrecioAcopio $precioAcopio, PrecioAcopioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'precioAcopio_index', $precioAcopio);
        if ($this->isCsrfTokenValid('delete_forever' . $precioAcopio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($precioAcopio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('precioAcopio_index');
    }
}
