<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\ReporteTerritorial;
use Pidia\Apps\Demo\Form\ReporteTerritorialType;
use Pidia\Apps\Demo\Manager\ReporteTerritorialManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/reporte/territorial')]
class ReporteTerritorialController extends BaseController
{
    #[Route(path: '/', name: 'reporteTerritorial_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'reporteTerritorial_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ReporteTerritorialManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'reporteTerritorial_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'reporteTerritorial/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'reporteTerritorial_export', methods: ['GET'])]
    public function export(Request $request, ReporteTerritorialManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'reporteTerritorial_index');
        $headers = [
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var reporteTerritorial $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['codigo'] = $objeto->getCodigo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'reporteTerritorial');
    }

    #[Route(path: '/new', name: 'reporteTerritorial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReporteTerritorialManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'reporteTerritorial_index');
        $reporteTerritorial = new reporteTerritorial();
        $form = $this->createForm(ReporteTerritorialType::class, $reporteTerritorial);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reporteTerritorial->setPropietario($this->getUser());
            if ($manager->save($reporteTerritorial)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('reporteTerritorial_index');
        }

        return $this->render(
            'reporteTerritorial/new.html.twig',
            [
                'reporteTerritorial' => $reporteTerritorial,
                'form' => $form->createView(),
            ]
        );
    }
    
    #[Route(path: '/{id}', name: 'reporteTerritorial_show', methods: ['GET'])]
    public function show(reporteTerritorial $reporteTerritorial): Response
    {
        $this->denyAccess(Access::VIEW, 'reporteTerritorial_index');

        return $this->render('reporteTerritorial/show.html.twig', ['reporteTerritorial' => $reporteTerritorial]);
    }

    #[Route(path: '/{id}/edit', name: 'reporteTerritorial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, reporteTerritorial $reporteTerritorial, ReporteTerritorialManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'reporteTerritorial_index');
        $form = $this->createForm(ReporteTerritorialType::class, $reporteTerritorial);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($reporteTerritorial)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('reporteTerritorial_index', ['id' => $reporteTerritorial->getId()]);
        }

        return $this->render(
            'reporteTerritorial/edit.html.twig',
            [
                'reporteTerritorial' => $reporteTerritorial,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'reporteTerritorial_delete', methods: ['POST'])]
    public function delete(Request $request, reporteTerritorial $reporteTerritorial, ReporteTerritorialManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'reporteTerritorial_index');
        if ($this->isCsrfTokenValid('delete'.$reporteTerritorial->getId(), $request->request->get('_token'))) {
            $reporteTerritorial->changeActivo();
            if ($manager->save($reporteTerritorial)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('reporteTerritorial_index');
    }

    #[Route(path: '/{id}/delete', name: 'reporteTerritorial_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, reporteTerritorial $reporteTerritorial, ReporteTerritorialManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'reporteTerritorial_index', $reporteTerritorial);
        if ($this->isCsrfTokenValid('delete_forever'.$reporteTerritorial->getId(), $request->request->get('_token'))) {
            if ($manager->remove($reporteTerritorial)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('reporteTerritorial_index');
    }
}
