<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\UnidadMedida;
use Pidia\Apps\Demo\Form\UnidadMedidaType;
use Pidia\Apps\Demo\Manager\UnidadMedidaManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/unidad/medida')]
class UnidadMedidaController extends BaseController
{
    #[Route(path: '/', name: 'unidadMedida_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'unidadMedida_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, UnidadMedidaManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'unidadMedida_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'unidadMedida/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'unidadMedida_export', methods: ['GET'])]
    public function export(Request $request, UnidadMedidaManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'unidadMedida_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alisas',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var unidadMedida $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['alias'] = $objeto->getAlias();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'unidadMedida');
    }

    #[Route(path: '/new', name: 'unidadMedida_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UnidadMedidaManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'unidadMedida_index');
        $unidadMedida = new unidadMedida();
        $form = $this->createForm(UnidadMedidaType::class, $unidadMedida);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unidadMedida->setPropietario($this->getUser());
            if ($manager->save($unidadMedida)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('unidadMedida_index');
        }

        return $this->render(
            'unidadMedida/new.html.twig',
            [
                'unidadMedida' => $unidadMedida,
                'form' => $form->createView(),
            ]
        );
    }
    
    #[Route(path: '/{id}', name: 'unidadMedida_show', methods: ['GET'])]
    public function show(unidadMedida $unidadMedida): Response
    {
        $this->denyAccess(Access::VIEW, 'unidadMedida_index');

        return $this->render('unidadMedida/show.html.twig', ['unidadMedida' => $unidadMedida]);
    }

    #[Route(path: '/{id}/edit', name: 'unidadMedida_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, unidadMedida $unidadMedida, UnidadMedidaManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'unidadMedida_index');
        $form = $this->createForm(UnidadMedidaType::class, $unidadMedida);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($unidadMedida)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('unidadMedida_index', ['id' => $unidadMedida->getId()]);
        }

        return $this->render(
            'unidadMedida/edit.html.twig',
            [
                'unidadMedida' => $unidadMedida,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'unidadMedida_delete', methods: ['POST'])]
    public function delete(Request $request, unidadMedida $unidadMedida, UnidadMedidaManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'unidadMedida_index');
        if ($this->isCsrfTokenValid('delete'.$unidadMedida->getId(), $request->request->get('_token'))) {
            $unidadMedida->changeActivo();
            if ($manager->save($unidadMedida)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('unidadMedida_index');
    }

    #[Route(path: '/{id}/delete', name: 'unidadMedida_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, unidadMedida $unidadMedida, UnidadMedidaManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'unidadMedida_index', $unidadMedida);
        if ($this->isCsrfTokenValid('delete_forever'.$unidadMedida->getId(), $request->request->get('_token'))) {
            if ($manager->remove($unidadMedida)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('unidadMedida_index');
    }
}
