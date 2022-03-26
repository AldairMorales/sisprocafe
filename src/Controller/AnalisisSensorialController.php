<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Form\AnalisisSensorialType;
use Pidia\Apps\Demo\Manager\AnalisisSensorialManager;

use Pidia\Apps\Demo\Repository\AnalisisSensorialRepository;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/analisis/sensorial')]
class AnalisisSensorialController extends BaseController
{
    #[Route(path: '/', name: 'analisisSensorial_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'analisisSensorial_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, AnalisisSensorialManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'analisisSensorial_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'analisisSensorial/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'analisisSensorial_export', methods: ['GET'])]
    public function export(Request $request, AnalisisSensorialManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'analisisSensorial_index');
        $headers = [
            'nombre' => 'Nombre',
            'tipoAnalisisSensorial' => 'Tipo AnalisisSensorial',
            'direccion' => 'Direccion',
            'empresa' => 'Empresa',
            'direccion' => 'Direccion',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var analisisSensorial $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            // $item['nombre'] = $objeto->getNombre();
            // $item['tipoAnalisisSensorial'] = $objeto->getTipoAnalisisSensorial();
            // $item['direccion'] = $objeto->getDireccion();
            // $item['empresa'] = $objeto->getEmpresa();
            // $item['direccion'] = $objeto->getDireccion();
            // $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'analisisSensorial');
    }

    #[Route(path: '/new', name: 'analisisSensorial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnalisisSensorialManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'analisisSensorial_index');
        $analisisSensorial = new analisisSensorial();
        $form = $this->createForm(AnalisisSensorialType::class, $analisisSensorial);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $analisisSensorial->setPropietario($this->getUser());
            if ($manager->save($analisisSensorial)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('analisisSensorial_index');
        }

        return $this->render(
            'analisisSensorial/new.html.twig',
            [
                'analisisSensorial' => $analisisSensorial,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'analisisSensorial_show', methods: ['GET'])]
    public function show(analisisSensorial $analisisSensorial): Response
    {
        $this->denyAccess(Access::VIEW, 'analisisSensorial_index');

        return $this->render('analisisSensorial/show.html.twig', ['analisisSensorial' => $analisisSensorial]);
    }

    #[Route(path: '/{id}/edit', name: 'analisisSensorial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, analisisSensorial $analisisSensorial, AnalisisSensorialManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'analisisSensorial_index');
        $form = $this->createForm(AnalisisSensorialType::class, $analisisSensorial);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($analisisSensorial)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('analisisSensorial_index', ['id' => $analisisSensorial->getId()]);
        }

        return $this->render(
            'analisisSensorial/edit.html.twig',
            [
                'analisisSensorial' => $analisisSensorial,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'analisisSensorial_delete', methods: ['POST'])]
    public function delete(Request $request, analisisSensorial $analisisSensorial, AnalisisSensorialManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'analisisSensorial_index');
        if ($this->isCsrfTokenValid('delete' . $analisisSensorial->getId(), $request->request->get('_token'))) {
            $analisisSensorial->changeActivo();
            if ($manager->save($analisisSensorial)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('analisisSensorial_index');
    }

    #[Route(path: '/{id}/delete', name: 'analisisSensorial_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, analisisSensorial $analisisSensorial, AnalisisSensorialManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'analisisSensorial_index', $analisisSensorial);
        if ($this->isCsrfTokenValid('delete_forever' . $analisisSensorial->getId(), $request->request->get('_token'))) {
            if ($manager->remove($analisisSensorial)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('analisisSensorial_index');
    }
    #[Route('/busqueda/id', name: 'analisisSensorial_busqueda_id')]

    public function busqueda_id(Request $request, AnalisisSensorialRepository $Repository): Response
    {

        $id = $request->request->get('id');
        $result = $Repository->analisisSensorial_id($id);
        return $this->json($result);
    }
}
