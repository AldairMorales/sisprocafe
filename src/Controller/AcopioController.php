<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Entity\Parametro;
use Pidia\Apps\Demo\Form\AcopioType;
use Pidia\Apps\Demo\Manager\AcopioManager;
use Pidia\Apps\Demo\Manager\ParametroManager;
use Pidia\Apps\Demo\Repository\AcopioRepository;
use Pidia\Apps\Demo\Repository\AnalisisFisicoRepository;
use Pidia\Apps\Demo\Repository\CertificacionRepository;
use Pidia\Apps\Demo\Repository\EmpresaRepository;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/acopio')]
class AcopioController extends BaseController
{
    #[Route(path: '/', name: 'acopio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'acopio_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, AcopioManager $manager, CertificacionRepository $certificacionRepository): Response
    {
        $this->denyAccess(Access::LIST, 'acopio_index');

        $paginator = $manager->listPaginated($request->query->all(), $page);

        return $this->render(
            'acopio/index.html.twig',
            [
                'paginator' => $paginator,
                'certificaciones' => $certificacionRepository->findAll(),
            ]
        );
    }

    #[Route(path: '/export', name: 'acopio_export', methods: ['GET'])]
    public function export(Request $request, AcopioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'acopio_index');
        $headers = [
            'periodo' => 'Periodo',
            'fecha' => 'Fecha',
            'socio' => 'Socio',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var Acopio $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['periodo'] = $objeto->getPeriodo();
            $item['icono'] = $objeto->getFecha();
            $item['orden'] = $objeto->getSocio();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/new', name: 'acopio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AcopioManager $manager, ParametroManager $Parametermanager): Response
    {
        $this->denyAccess(Access::NEW, 'acopio_index');
        $acopio = new Acopio();
        $parametro = $Parametermanager->manager()->getRepository(Parametro::class)->findOneBy(['alias' => 'PROCESO']);
        $form = $this->createForm(AcopioType::class, $acopio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $acopio->setEstado($parametro);
            $acopio->setPropietario($this->getUser());
            if ($manager->save($acopio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('acopio_index');
        }

        return $this->render(
            'acopio/new.html.twig',
            [
                'acopio' => $acopio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id<\d+>}', name: 'acopio_show', methods: ['GET'])]
    public function show(Acopio $acopio): Response
    {
        $this->denyAccess(Access::VIEW, 'acopio_index');

        return $this->render('acopio/show.html.twig', ['acopio' => $acopio]);
    }

    #[Route(path: '/report/dia', name: 'acopio_report_dia', methods: ['GET'])]
    public function report_dia(AcopioRepository $acopioRepository, EmpresaRepository $empresaRepository): Response
    {
        $this->denyAccess(Access::LIST, 'acopio_index');
        $Object = new \DateTime();
        $fecha_actual = $Object->format('Y-m-d');
        $diaAnterior = date('Y-m-d', strtotime($fecha_actual.'- 1 days'));
        $acopios = $acopioRepository->reportePorCliente($diaAnterior);
        $empresa = $empresaRepository->find(1);

        return $this->render('acopio/report.html.twig', ['acopios' => $acopios, 'empresa' => $empresa]);
    }

    #[Route(path: '/report/semana', name: 'acopio_report_semana', methods: ['GET'])]
    public function report_semana(AcopioRepository $acopioRepository, EmpresaRepository $empresaRepository): Response
    {
        $this->denyAccess(Access::LIST, 'acopio_index');
        $Object = new \DateTime();
        $fecha_actual = $Object->format('Y-m-d');

        $semanaAnterior = date('Y-m-d', strtotime($fecha_actual.'- 1 week'));
        $acopios = $acopioRepository->reportePorCliente($semanaAnterior);
        $empresa = $empresaRepository->find(1);

        return $this->render('acopio/report.html.twig', ['acopios' => $acopios, 'empresa' => $empresa]);
    }

    #[Route(path: '/report/mes', name: 'acopio_report_mes', methods: ['GET'])]
    public function report_mes(AcopioRepository $acopioRepository, EmpresaRepository $empresaRepository): Response
    {
        $this->denyAccess(Access::LIST, 'acopio_index');
        $Object = new \DateTime();
        $fecha_actual = $Object->format('Y-m-d');
        $mesAnterior = date('d-m-Y', strtotime($fecha_actual.'- 1 month'));
        $acopios = $acopioRepository->reportePorCliente($mesAnterior);
        $empresa = $empresaRepository->find(1);

        return $this->render('acopio/report.html.twig', ['acopios' => $acopios, 'empresa' => $empresa]);
    }

    #[Route(path: '/{id<\d+>}/pago', name: 'acopio_pago', methods: ['GET'])]
    public function pago(Request $request, Acopio $acopio, AnalisisFisicoRepository $Repository, AcopioManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'acopio_index');
        $analisisFisico = $Repository->buscarFisico($acopio->getId());
        $formAcopio = $this->createForm(AcopioType::class, $acopio);

        $formAcopio->handleRequest($request);
        if ($formAcopio->isSubmitted() && $formAcopio->isValid()) {
            if ($manager->save($acopio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('acopio_index', ['id' => $acopio->getId()]);
        }

        return $this->render('acopio/pago.html.twig', ['analisisFisico' => $analisisFisico, 'acopio' => $acopio]);
    }

    #[Route(path: '/{id<\d+>}/edit', name: 'acopio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Acopio $acopio, AcopioManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'acopio_index');
        $form = $this->createForm(AcopioType::class, $acopio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($acopio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('acopio_index', ['id' => $acopio->getId()]);
        }

        return $this->render(
            'acopio/edit.html.twig',
            [
                'acopio' => $acopio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id<\d+>}', name: 'acopio_delete', methods: ['POST'])]
    public function delete(Request $request, Acopio $acopio, AcopioManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'acopio_index');
        if ($this->isCsrfTokenValid('delete'.$acopio->getId(), $request->request->get('_token'))) {
            $acopio->changeActivo();
            if ($manager->save($acopio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('acopio_index');
    }

    #[Route(path: '/{id<\d+>}/delete', name: 'acopio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Acopio $acopio, AcopioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'acopio_index', $acopio);
        if ($this->isCsrfTokenValid('delete_forever'.$acopio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($acopio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('acopio_index');
    }

    #[Route('/busqueda/id/', name: 'acopio_busqueda_id')]
    public function busqueda_id(AcopioRepository $Repository): Response
    {
        $result = $Repository->Acopio_Id();

        return $this->json($result);
    }
}
