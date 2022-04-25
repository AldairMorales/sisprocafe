<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\AnalisisFisico;
use Pidia\Apps\Demo\Form\AnalisisFisicoType;
use Pidia\Apps\Demo\Manager\AnalisisFisicoManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pidia\Apps\Demo\Repository\AcopioRepository;

#[Route('/admin/analisis/fisico')]
class AnalisisFisicoController extends BaseController
{
    #[Route(path: '/', name: 'analisisFisico_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'analisisFisico_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, AnalisisFisicoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'analisisFisico_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'analisisFisico/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'analisisFisico_export', methods: ['GET'])]
    public function export(Request $request, AnalisisFisicoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'analisisFisico_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alisas',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var analisisFisico $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            // $item['nombre'] = $objeto->getNombre();
            // $item['alias'] = $objeto->getAlias();
            // $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'analisisFisico');
    }

    #[Route(path: '/new', name: 'analisisFisico_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnalisisFisicoManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'analisisFisico_index');
        $analisisFisico = new AnalisisFisico();
        $form = $this->createForm(AnalisisFisicoType::class, $analisisFisico);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $analisisFisico->setPropietario($this->getUser());

            if ($manager->save($analisisFisico)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('analisisFisico_index');
        }

        return $this->render(
            'analisisFisico/new.html.twig',
            [
                'analisisFisico' => $analisisFisico,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'analisisFisico_show', methods: ['GET'])]
    public function show(analisisFisico $analisisFisico): Response
    {
        $this->denyAccess(Access::VIEW, 'analisisFisico_index');

        return $this->render('analisisFisico/show.html.twig', ['analisisFisico' => $analisisFisico]);
    }

    #[Route(path: '/{id}/edit', name: 'analisisFisico_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, analisisFisico $analisisFisico, AnalisisFisicoManager $manager, AcopioRepository $repository): Response
    {
        $this->denyAccess(Access::EDIT, 'analisisFisico_index');
        $form = $this->createForm(AnalisisFisicoType::class, $analisisFisico);
        //$repository->actualizar_AnalisisFisico(false, $analisisFisico->getAcopio());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($analisisFisico)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('analisisFisico_index', ['id' => $analisisFisico->getId()]);
        }

        return $this->render(
            'analisisFisico/edit.html.twig',
            [
                'analisisFisico' => $analisisFisico,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'analisisFisico_delete', methods: ['POST'])]
    public function delete(Request $request, analisisFisico $analisisFisico, AnalisisFisicoManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'analisisFisico_index');
        if ($this->isCsrfTokenValid('delete' . $analisisFisico->getId(), $request->request->get('_token'))) {
            $analisisFisico->changeActivo();
            if ($manager->save($analisisFisico)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('analisisFisico_index');
    }

    #[Route(path: '/{id}/delete', name: 'analisisFisico_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, analisisFisico $analisisFisico, AnalisisFisicoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'analisisFisico_index', $analisisFisico);
        if ($this->isCsrfTokenValid('delete_forever' . $analisisFisico->getId(), $request->request->get('_token'))) {
            if ($manager->remove($analisisFisico)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('analisisFisico_index');
    }
}
