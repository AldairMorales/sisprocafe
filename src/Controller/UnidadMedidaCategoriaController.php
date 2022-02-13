<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\UnidadMedidaCategoria;
use Pidia\Apps\Demo\Form\UnidadMedidaCategoriaType;
use Pidia\Apps\Demo\Manager\UnidadMedidaCategoriaManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/unidadMedida/categoria')]
class UnidadMedidaCategoriaController extends BaseController
{
    #[Route(path: '/', name: 'unidadMedidaCategoria_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'unidadMedidaCategoria_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, UnidadMedidaCategoriaManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'unidadMedidaCategoria_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'unidadMedidaCategoria/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'unidadMedidaCategoria_export', methods: ['GET'])]
    public function export(Request $request, UnidadMedidaCategoriaManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'unidadMedidaCategoria_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alisas',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var unidadMedidaCategoria $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['alias'] = $objeto->getAlias();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'unidadMedidaCategoria');
    }

    #[Route(path: '/new', name: 'unidadMedidaCategoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UnidadMedidaCategoriaManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'unidadMedidaCategoria_index');
        $unidadMedidaCategoria = new unidadMedidaCategoria();
        $form = $this->createForm(UnidadMedidaCategoriaType::class, $unidadMedidaCategoria);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unidadMedidaCategoria->setPropietario($this->getUser());
            if ($manager->save($unidadMedidaCategoria)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('unidadMedidaCategoria_index');
        }

        return $this->render(
            'unidadMedidaCategoria/new.html.twig',
            [
                'unidadMedidaCategoria' => $unidadMedidaCategoria,
                'form' => $form->createView(),
            ]
        );
    }
    
    #[Route(path: '/{id}', name: 'unidadMedidaCategoria_show', methods: ['GET'])]
    public function show(unidadMedidaCategoria $unidadMedidaCategoria): Response
    {
        $this->denyAccess(Access::VIEW, 'unidadMedidaCategoria_index');

        return $this->render('unidadMedidaCategoria/show.html.twig', ['unidadMedidaCategoria' => $unidadMedidaCategoria]);
    }

    #[Route(path: '/{id}/edit', name: 'unidadMedidaCategoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, unidadMedidaCategoria $unidadMedidaCategoria, UnidadMedidaCategoriaManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'unidadMedidaCategoria_index');
        $form = $this->createForm(UnidadMedidaCategoriaType::class, $unidadMedidaCategoria);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($unidadMedidaCategoria)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('unidadMedidaCategoria_index', ['id' => $unidadMedidaCategoria->getId()]);
        }

        return $this->render(
            'unidadMedidaCategoria/edit.html.twig',
            [
                'unidadMedidaCategoria' => $unidadMedidaCategoria,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'unidadMedidaCategoria_delete', methods: ['POST'])]
    public function delete(Request $request, unidadMedidaCategoria $unidadMedidaCategoria, UnidadMedidaCategoriaManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'unidadMedidaCategoria_index');
        if ($this->isCsrfTokenValid('delete'.$unidadMedidaCategoria->getId(), $request->request->get('_token'))) {
            $unidadMedidaCategoria->changeActivo();
            if ($manager->save($unidadMedidaCategoria)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('unidadMedidaCategoria_index');
    }

    #[Route(path: '/{id}/delete', name: 'unidadMedidaCategoria_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, unidadMedidaCategoria $unidadMedidaCategoria, UnidadMedidaCategoriaManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'unidadMedidaCategoria_index', $unidadMedidaCategoria);
        if ($this->isCsrfTokenValid('delete_forever'.$unidadMedidaCategoria->getId(), $request->request->get('_token'))) {
            if ($manager->remove($unidadMedidaCategoria)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('unidadMedidaCategoria_index');
    }
}
