<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Producto;
use Pidia\Apps\Demo\Form\ProductoType;
use Pidia\Apps\Demo\Manager\ProductoManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/producto')]
class ProductoController extends BaseController
{
    #[Route(path: '/', name: 'producto_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'producto_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ProductoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'producto_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'producto/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'producto_export', methods: ['GET'])]
    public function export(Request $request, ProductoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'producto_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alias',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var Producto $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['alias'] = $objeto->getAlias();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/new', name: 'producto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductoManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'producto_index');
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producto->setPropietario($this->getUser());
            if ($manager->save($producto)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('producto_index');
        }

        return $this->render(
            'producto/new.html.twig',
            [
                'producto' => $producto,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        $this->denyAccess(Access::VIEW, 'producto_index');

        return $this->render('producto/show.html.twig', ['producto' => $producto]);
    }

    #[Route(path: '/{id}/edit', name: 'producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, ProductoManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'producto_index');
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($producto)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('producto_index', ['id' => $producto->getId()]);
        }

        return $this->render(
            'producto/edit.html.twig',
            [
                'producto' => $producto,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, ProductoManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'producto_index');
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $producto->changeActivo();
            if ($manager->save($producto)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('producto_index');
    }

    #[Route(path: '/{id}/delete', name: 'producto_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Producto $producto, ProductoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'producto_index', $producto);
        if ($this->isCsrfTokenValid('delete_forever'.$producto->getId(), $request->request->get('_token'))) {
            if ($manager->remove($producto)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('producto_index');
    }
}
