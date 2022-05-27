<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Traslado;
use Pidia\Apps\Demo\Form\TrasladoType;
use Pidia\Apps\Demo\Manager\TrasladoManager;
use Pidia\Apps\Demo\Repository\TrasladoRepository;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/traslado')]
class TrasladoController extends BaseController
{
    #[Route(path: '/', defaults: ['page' => '1'], methods: ['GET'], name: 'traslado_index')]
    #[Route(path: '/page/{page<[1-9]\d*>}', methods: ['GET'], name: 'traslado_index_paginated')]
    public function index(Request $request, int $page, TrasladoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'traslado_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'traslado/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', methods: ['GET'], name: 'traslado_export')]
    public function export(Request $request, TrasladoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'traslado_index');
        $headers = [
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var Traslado $objeto */
        foreach ($objetos as $objeto) {
            // // $item = [];
            // // $item['nombre'] = $objeto->getNombreCompleto();
            // // $item['codigo'] = $objeto->getCodigo();
            // // $item['activo'] = $objeto->activo();
            // $data[] = $item;
            // unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'traslado');
    }

    #[Route(path: '/new', name: 'traslado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrasladoManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'traslado_index');
        $traslado = new Traslado();
        $form = $this->createForm(TrasladoType::class, $traslado);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $traslado->setPropietario($this->getUser());
            if ($manager->save($traslado)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('traslado_index');
        }

        return $this->render(
            'traslado/new.html.twig',
            [
                'traslado' => $traslado,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'traslado_show', methods: ['GET'])]
    public function show(Traslado $traslado): Response
    {
        $this->denyAccess(Access::VIEW, 'traslado_index');

        return $this->render('traslado/show.html.twig', ['traslado' => $traslado]);
    }

    #[Route(path: '/{id}/edit', name: 'traslado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Traslado $traslado, TrasladoManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'traslado_index');
        $form = $this->createForm(TrasladoType::class, $traslado);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($traslado)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('traslado_index', ['id' => $traslado->getId()]);
        }

        return $this->render(
            'traslado/edit.html.twig',
            [
                'traslado' => $traslado,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'traslado_delete', methods: ['POST'])]
    public function delete(Request $request, Traslado $traslado, TrasladoManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'traslado_index');
        if ($this->isCsrfTokenValid('delete' . $traslado->getId(), $request->request->get('_token'))) {
            $traslado->changeActivo();
            if ($manager->save($traslado)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('traslado_index');
    }

    #[Route(path: '/{id}/delete', name: 'traslado_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Traslado $traslado, TrasladoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'traslado_index', $traslado);
        if ($this->isCsrfTokenValid('delete_forever' . $traslado->getId(), $request->request->get('_token'))) {
            if ($manager->remove($traslado)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('traslado_index');
    }
    #[Route('/busqueda/traslado/', name: 'ultimo_traslado_id')]
    public function busqueda_id(TrasladoRepository $Repository): Response
    {
        $result = $Repository->ultimo_traslado_Id();
        return $this->json($result);
    }
}
