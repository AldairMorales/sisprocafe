<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Almacen;
use Pidia\Apps\Demo\Form\AlmacenType;
use Pidia\Apps\Demo\Manager\AlmacenManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/almacen')]
class AlmacenController extends BaseController
{
    #[Route(path: '/', name: 'almacen_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'almacen_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, AlmacenManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'almacen_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'almacen/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'almacen_export', methods: ['GET'])]
    public function export(Request $request, AlmacenManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'almacen_index');
        $headers = [
            'nombre' => 'Nombre',
            'tipoAlmacen' => 'Tipo Almacen',
            'direccion' => 'Direccion',
            'empresa' => 'Empresa',
            'direccion' => 'Direccion',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var almacen $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['tipoAlmacen'] = $objeto->getTipoAlmacen();
            $item['direccion'] = $objeto->getDireccion();
            $item['empresa'] = $objeto->getEmpresa();
            $item['direccion'] = $objeto->getDireccion();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'almacen');
    }

    #[Route(path: '/new', name: 'almacen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AlmacenManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'almacen_index');
        $almacen = new almacen();
        $form = $this->createForm(AlmacenType::class, $almacen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $almacen->setPropietario($this->getUser());
            if ($manager->save($almacen)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('almacen_index');
        }

        return $this->render(
            'almacen/new.html.twig',
            [
                'almacen' => $almacen,
                'form' => $form->createView(),
            ]
        );
    }
    
    #[Route(path: '/{id}', name: 'almacen_show', methods: ['GET'])]
    public function show(almacen $almacen): Response
    {
        $this->denyAccess(Access::VIEW, 'almacen_index');

        return $this->render('almacen/show.html.twig', ['almacen' => $almacen]);
    }

    #[Route(path: '/{id}/edit', name: 'almacen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, almacen $almacen, AlmacenManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'almacen_index');
        $form = $this->createForm(AlmacenType::class, $almacen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($almacen)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('almacen_index', ['id' => $almacen->getId()]);
        }

        return $this->render(
            'almacen/edit.html.twig',
            [
                'almacen' => $almacen,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'almacen_delete', methods: ['POST'])]
    public function delete(Request $request, almacen $almacen, AlmacenManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'almacen_index');
        if ($this->isCsrfTokenValid('delete'.$almacen->getId(), $request->request->get('_token'))) {
            $almacen->changeActivo();
            if ($manager->save($almacen)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('almacen_index');
    }

    #[Route(path: '/{id}/delete', name: 'almacen_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, almacen $almacen, AlmacenManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'almacen_index', $almacen);
        if ($this->isCsrfTokenValid('delete_forever'.$almacen->getId(), $request->request->get('_token'))) {
            if ($manager->remove($almacen)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('almacen_index');
    }
}
