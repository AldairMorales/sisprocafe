<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Certificacion;
use Pidia\Apps\Demo\Form\CertificacionType;
use Pidia\Apps\Demo\Manager\CertificacionManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/certificacion')]
class CertificacionController extends BaseController
{
    #[Route(path: '/', name: 'certificacion_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'certificacion_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, CertificacionManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'certificacion_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'certificacion/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'certificacion_export', methods: ['GET'])]
    public function export(Request $request, CertificacionManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'certificacion_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alisas',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var certificacion $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['alias'] = $objeto->getAlias();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'certificacion');
    }

    #[Route(path: '/new', name: 'certificacion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CertificacionManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'certificacion_index');
        $certificacion = new certificacion();
        $form = $this->createForm(CertificacionType::class, $certificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $certificacion->setPropietario($this->getUser());
            if ($manager->save($certificacion)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('certificacion_index');
        }

        return $this->render(
            'certificacion/new.html.twig',
            [
                'certificacion' => $certificacion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'certificacion_show', methods: ['GET'])]
    public function show(certificacion $certificacion): Response
    {
        $this->denyAccess(Access::VIEW, 'certificacion_index');

        return $this->render('certificacion/show.html.twig', ['certificacion' => $certificacion]);
    }

    #[Route(path: '/{id}/edit', name: 'certificacion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, certificacion $certificacion, CertificacionManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'certificacion_index');
        $form = $this->createForm(CertificacionType::class, $certificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($certificacion)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('certificacion_index', ['id' => $certificacion->getId()]);
        }

        return $this->render(
            'certificacion/edit.html.twig',
            [
                'certificacion' => $certificacion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'certificacion_delete', methods: ['POST'])]
    public function delete(Request $request, certificacion $certificacion, CertificacionManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'certificacion_index');
        if ($this->isCsrfTokenValid('delete' . $certificacion->getId(), $request->request->get('_token'))) {
            $certificacion->changeActivo();
            if ($manager->save($certificacion)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('certificacion_index');
    }

    #[Route(path: '/{id}/delete', name: 'certificacion_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, certificacion $certificacion, CertificacionManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'certificacion_index', $certificacion);
        if ($this->isCsrfTokenValid('delete_forever' . $certificacion->getId(), $request->request->get('_token'))) {
            if ($manager->remove($certificacion)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('certificacion_index');
    }
}
