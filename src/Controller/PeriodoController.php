<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Periodo;
use Pidia\Apps\Demo\Form\PeriodoType;
use Pidia\Apps\Demo\Manager\PeriodoManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/periodo')]
class PeriodoController extends BaseController
{
    #[Route(path: '/', name: 'periodo_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'periodo_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, PeriodoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'periodo_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'periodo/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'periodo_export', methods: ['GET'])]
    public function export(Request $request, PeriodoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'periodo_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alias',
            'descripcion' => 'Descripcion',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFinal' => 'Fehca Final',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var Periodo $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['alias'] = $objeto->getAlias();
            $item['descripcion'] = $objeto->getDescripcion();
            $item['fechaInicio'] = $objeto->getFechaInicio();
            $item['fechaFinal'] = $objeto->getFechaFinal();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/new', name: 'periodo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PeriodoManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'periodo_index');
        $periodo = new Periodo();
        $form = $this->createForm(PeriodoType::class, $periodo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $periodo->setPropietario($this->getUser());
            if ($manager->save($periodo)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('periodo_index');
        }

        return $this->render(
            'periodo/new.html.twig',
            [
                'periodo' => $periodo,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'periodo_show', methods: ['GET'])]
    public function show(Periodo $periodo): Response
    {
        $this->denyAccess(Access::VIEW, 'periodo_index');

        return $this->render('periodo/show.html.twig', ['periodo' => $periodo]);
    }

    #[Route(path: '/{id}/edit', name: 'periodo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Periodo $periodo, PeriodoManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'periodo_index');
        $form = $this->createForm(PeriodoType::class, $periodo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($periodo)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('periodo_index', ['id' => $periodo->getId()]);
        }

        return $this->render(
            'periodo/edit.html.twig',
            [
                'periodo' => $periodo,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'periodo_delete', methods: ['POST'])]
    public function delete(Request $request, Periodo $periodo, PeriodoManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'periodo_index');
        if ($this->isCsrfTokenValid('delete'.$periodo->getId(), $request->request->get('_token'))) {
            $periodo->changeActivo();
            if ($manager->save($periodo)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('periodo_index');
    }

    #[Route(path: '/{id}/delete', name: 'periodo_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Periodo $periodo, PeriodoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'periodo_index', $periodo);
        if ($this->isCsrfTokenValid('delete_forever'.$periodo->getId(), $request->request->get('_token'))) {
            if ($manager->remove($periodo)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('periodo_index');
    }
}
