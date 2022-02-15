<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\UnidadEquivalencia;
use Pidia\Apps\Demo\Form\UnidadEquivalenciaType;
use Pidia\Apps\Demo\Manager\UnidadEquivalenciaManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/unidad/equivalencia')]
class UnidadEquivalenciaController extends BaseController
{
    #[Route(path: '/', name: 'unidadEquivalencia_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'unidadEquivalencia_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, UnidadEquivalenciaManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'unidadEquivalencia_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'unidadEquivalencia/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'unidadEquivalencia_export', methods: ['GET'])]
    public function export(Request $request, UnidadEquivalenciaManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'unidadEquivalencia_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alisas',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var unidadEquivalencia $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['unidad'] = $objeto->getUnidad();
            $item['categoria'] = $objeto->getUnidadMedida();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'unidadEquivalencia');
    }

    #[Route(path: '/new', name: 'unidadEquivalencia_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UnidadEquivalenciaManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'unidadEquivalencia_index');
        $unidadEquivalencia = new unidadEquivalencia();
        $form = $this->createForm(UnidadEquivalenciaType::class, $unidadEquivalencia);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unidadEquivalencia->setPropietario($this->getUser());
            if ($manager->save($unidadEquivalencia)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('unidadEquivalencia_index');
        }

        return $this->render(
            'unidadEquivalencia/new.html.twig',
            [
                'unidadEquivalencia' => $unidadEquivalencia,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'unidadEquivalencia_show', methods: ['GET'])]
    public function show(unidadEquivalencia $unidadEquivalencia): Response
    {
        $this->denyAccess(Access::VIEW, 'unidadEquivalencia_index');

        return $this->render('unidadEquivalencia/show.html.twig', ['unidadEquivalencia' => $unidadEquivalencia]);
    }

    #[Route(path: '/{id}/edit', name: 'unidadEquivalencia_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, unidadEquivalencia $unidadEquivalencia, UnidadEquivalenciaManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'unidadEquivalencia_index');
        $form = $this->createForm(UnidadEquivalenciaType::class, $unidadEquivalencia);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($unidadEquivalencia)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('unidadEquivalencia_index', ['id' => $unidadEquivalencia->getId()]);
        }

        return $this->render(
            'unidadEquivalencia/edit.html.twig',
            [
                'unidadEquivalencia' => $unidadEquivalencia,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'unidadEquivalencia_delete', methods: ['POST'])]
    public function delete(Request $request, unidadEquivalencia $unidadEquivalencia, UnidadEquivalenciaManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'unidadEquivalencia_index');
        if ($this->isCsrfTokenValid('delete' . $unidadEquivalencia->getId(), $request->request->get('_token'))) {
            $unidadEquivalencia->changeActivo();
            if ($manager->save($unidadEquivalencia)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('unidadEquivalencia_index');
    }

    #[Route(path: '/{id}/delete', name: 'unidadEquivalencia_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, unidadEquivalencia $unidadEquivalencia, UnidadEquivalenciaManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'unidadEquivalencia_index', $unidadEquivalencia);
        if ($this->isCsrfTokenValid('delete_forever' . $unidadEquivalencia->getId(), $request->request->get('_token'))) {
            if ($manager->remove($unidadEquivalencia)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('unidadEquivalencia_index');
    }
}
