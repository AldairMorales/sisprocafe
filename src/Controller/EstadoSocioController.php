<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\EstadoSocio;
use Pidia\Apps\Demo\Form\EstadoSocioType;
use Pidia\Apps\Demo\Manager\EstadoSocioManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/estado/socio')]
class EstadoSocioController extends BaseController
{
    #[Route(path: '/', name: 'estado_socio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'estado_socio_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EstadoSocioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'estado_socio_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'estado_socio/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'estado_socio_export', methods: ['GET'])]
    public function export(Request $request, EstadoSocioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'estado_socio_index');
        $headers = [
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var EstadoSocio $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['descripcion'] = $objeto->getDescripcion();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/new', name: 'estado_socio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EstadoSocioManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'estado_socio_index');
        $estado_socio = new EstadoSocio();
        $form = $this->createForm(EstadoSocioType::class, $estado_socio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $estado_socio->setPropietario($this->getUser());
            if ($manager->save($estado_socio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('estado_socio_index');
        }

        return $this->render(
            'estado_socio/new.html.twig',
            [
                'estado_socio' => $estado_socio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'estado_socio_show', methods: ['GET'])]
    public function show(EstadoSocio $estado_socio): Response
    {
        $this->denyAccess(Access::VIEW, 'estado_socio_index');

        return $this->render('estado_socio/show.html.twig', ['estado_socio' => $estado_socio]);
    }

    #[Route(path: '/{id}/edit', name: 'estado_socio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EstadoSocio $estado_socio, EstadoSocioManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'estado_socio_index');
        $form = $this->createForm(EstadoSocioType::class, $estado_socio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($estado_socio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('estado_socio_index', ['id' => $estado_socio->getId()]);
        }

        return $this->render(
            'estado_socio/edit.html.twig',
            [
                'estado_socio' => $estado_socio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'estado_socio_delete', methods: ['POST'])]
    public function delete(Request $request, EstadoSocio $estado_socio, EstadoSocioManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'estado_socio_index');
        if ($this->isCsrfTokenValid('delete'.$estado_socio->getId(), $request->request->get('_token'))) {
            $estado_socio->changeActivo();
            if ($manager->save($estado_socio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('estado_socio_index');
    }

    #[Route(path: '/{id}/delete', name: 'estado_socio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, EstadoSocio $estado_socio, EstadoSocioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'estado_socio_index', $estado_socio);
        if ($this->isCsrfTokenValid('delete_forever'.$estado_socio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($estado_socio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('estado_socio_index');
    }

}
