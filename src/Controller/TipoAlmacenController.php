<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\TipoAlmacen;
use Pidia\Apps\Demo\Form\TipoAlmacenType;
use Pidia\Apps\Demo\Manager\TipoAlmacenManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tipo/almacen')]
class TipoAlmacenController extends BaseController
{
    #[Route(path: '/', name: 'tipoAlmacen_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'tipoAlmacen_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, TipoAlmacenManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'tipoAlmacen_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'tipoAlmacen/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'tipoAlmacen_export', methods: ['GET'])]
    public function export(Request $request, TipoAlmacenManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'tipoAlmacen_index');
        $headers = [
            'nombre' => 'Nombre',
            'detalle' => 'Detalle',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var tipoAlmacen $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['detalle'] = $objeto->getDetalle();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'tipoAlmacen');
    }

    #[Route(path: '/new', name: 'tipoAlmacen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TipoAlmacenManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'tipoAlmacen_index');
        $tipoAlmacen = new tipoAlmacen();
        $form = $this->createForm(TipoAlmacenType::class, $tipoAlmacen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tipoAlmacen->setPropietario($this->getUser());
            if ($manager->save($tipoAlmacen)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipoAlmacen_index');
        }

        return $this->render(
            'tipoAlmacen/new.html.twig',
            [
                'tipoAlmacen' => $tipoAlmacen,
                'form' => $form->createView(),
            ]
        );
    }
    
    #[Route(path: '/{id}', name: 'tipoAlmacen_show', methods: ['GET'])]
    public function show(tipoAlmacen $tipoAlmacen): Response
    {
        $this->denyAccess(Access::VIEW, 'tipoAlmacen_index');

        return $this->render('tipoAlmacen/show.html.twig', ['tipoAlmacen' => $tipoAlmacen]);
    }

    #[Route(path: '/{id}/edit', name: 'tipoAlmacen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, tipoAlmacen $tipoAlmacen, TipoAlmacenManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'tipoAlmacen_index');
        $form = $this->createForm(TipoAlmacenType::class, $tipoAlmacen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipoAlmacen)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipoAlmacen_index', ['id' => $tipoAlmacen->getId()]);
        }

        return $this->render(
            'tipoAlmacen/edit.html.twig',
            [
                'tipoAlmacen' => $tipoAlmacen,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'tipoAlmacen_delete', methods: ['POST'])]
    public function delete(Request $request, tipoAlmacen $tipoAlmacen, TipoAlmacenManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'tipoAlmacen_index');
        if ($this->isCsrfTokenValid('delete'.$tipoAlmacen->getId(), $request->request->get('_token'))) {
            $tipoAlmacen->changeActivo();
            if ($manager->save($tipoAlmacen)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipoAlmacen_index');
    }

    #[Route(path: '/{id}/delete', name: 'tipoAlmacen_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, tipoAlmacen $tipoAlmacen, TipoAlmacenManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'tipoAlmacen_index', $tipoAlmacen);
        if ($this->isCsrfTokenValid('delete_forever'.$tipoAlmacen->getId(), $request->request->get('_token'))) {
            if ($manager->remove($tipoAlmacen)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipoAlmacen_index');
    }
}
