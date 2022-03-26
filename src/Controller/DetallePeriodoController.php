<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\DetallePeriodo;
use Pidia\Apps\Demo\Form\DetallePeriodoType;
use Pidia\Apps\Demo\Manager\DetallePeriodoManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/detalle/periodo')]
class DetallePeriodoController extends BaseController
{
    #[Route(path: '/', name: 'detalle_periodo_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'detalle_periodo_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, DetallePeriodoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'detalle_periodo_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'detalle_periodo/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'detalle_periodo_export', methods: ['GET'])]
    public function export(Request $request, DetallePeriodoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'detalle_periodo_index');
        $headers = [
            'acciones' => 'Acciones',
            'tara' => 'Tara',
            'humedadInicial' => 'Humedad Inicial',
            'muestra' => 'Muestra',
            'unidadMedida' => 'Unidad Medida',
            'envase' => 'Envase',
            'moneda' => 'Moneda',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var DetallePeriodo $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['acciones'] = $objeto->getAcciones();
            $item['tara'] = $objeto->getTara();
            $item['humedadInicial'] = $objeto->getHumedadInicial();
            $item['muestra'] = $objeto->getMuestra();
            $item['unidadMedida'] = $objeto->getUnidadMedida();
            $item['envase'] = $objeto->getEnvase();
            $item['moneda'] = $objeto->getMoneda();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/new', name: 'detalle_periodo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DetallePeriodoManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'detalle_periodo_index');
        $detalle_periodo = new DetallePeriodo();
        $form = $this->createForm(DetallePeriodoType::class, $detalle_periodo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $detalle_periodo->setPropietario($this->getUser());
            if ($manager->save($detalle_periodo)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('detalle_periodo_index');
        }

        return $this->render(
            'detalle_periodo/new.html.twig',
            [
                'detalle_periodo' => $detalle_periodo,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'detalle_periodo_show', methods: ['GET'])]
    public function show(DetallePeriodo $detalle_periodo): Response
    {
        $this->denyAccess(Access::VIEW, 'detalle_periodo_index');

        return $this->render('detalle_periodo/show.html.twig', ['detalle_periodo' => $detalle_periodo]);
    }

    #[Route(path: '/{id}/edit', name: 'detalle_periodo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetallePeriodo $detalle_periodo, DetallePeriodoManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'detalle_periodo_index');
        $form = $this->createForm(DetallePeriodoType::class, $detalle_periodo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($detalle_periodo)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('detalle_periodo_index', ['id' => $detalle_periodo->getId()]);
        }

        return $this->render(
            'detalle_periodo/edit.html.twig',
            [
                'detalle_periodo' => $detalle_periodo,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'detalle_periodo_delete', methods: ['POST'])]
    public function delete(Request $request, DetallePeriodo $detalle_periodo, DetallePeriodoManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'detalle_periodo_index');
        if ($this->isCsrfTokenValid('delete'.$detalle_periodo->getId(), $request->request->get('_token'))) {
            $detalle_periodo->changeActivo();
            if ($manager->save($detalle_periodo)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('detalle_periodo_index');
    }

    #[Route(path: '/{id}/delete', name: 'detalle_periodo_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, DetallePeriodo $detalle_periodo, DetallePeriodoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'detalle_periodo_index', $detalle_periodo);
        if ($this->isCsrfTokenValid('delete_forever'.$detalle_periodo->getId(), $request->request->get('_token'))) {
            if ($manager->remove($detalle_periodo)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('detalle_periodo_index');
    }
}
