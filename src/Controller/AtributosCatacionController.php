<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\AtributosCatacion;
use Pidia\Apps\Demo\Form\AtributosCatacionType;
use Pidia\Apps\Demo\Manager\AtributosCatacionManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/atributos/catacion')]
class AtributosCatacionController extends BaseController
{
    #[Route(path: '/', name: 'atributosCatacion_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'atributosCatacion_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, AtributosCatacionManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'atributosCatacion_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'atributosCatacion/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'atributosCatacion_export', methods: ['GET'])]
    public function export(Request $request, AtributosCatacionManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'atributosCatacion_index');
        $headers = [
            'nombre' => 'Nombre',
            'tipoAtributosCatacion' => 'Tipo AtributosCatacion',
            'direccion' => 'Direccion',
            'empresa' => 'Empresa',
            'direccion' => 'Direccion',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var atributosCatacion $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            // $item['tipoAtributosCatacion'] = $objeto->getTipoAtributosCatacion();
            // $item['direccion'] = $objeto->getDireccion();
            // $item['empresa'] = $objeto->getEmpresa();
            // $item['direccion'] = $objeto->getDireccion();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'atributosCatacion');
    }

    #[Route(path: '/new', name: 'atributosCatacion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AtributosCatacionManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'atributosCatacion_index');
        $atributosCatacion = new atributosCatacion();
        $form = $this->createForm(AtributosCatacionType::class, $atributosCatacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $atributosCatacion->setPropietario($this->getUser());
            if ($manager->save($atributosCatacion)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('atributosCatacion_index');
        }

        return $this->render(
            'atributosCatacion/new.html.twig',
            [
                'atributosCatacion' => $atributosCatacion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'atributosCatacion_show', methods: ['GET'])]
    public function show(atributosCatacion $atributosCatacion): Response
    {
        $this->denyAccess(Access::VIEW, 'atributosCatacion_index');

        return $this->render('atributosCatacion/show.html.twig', ['atributosCatacion' => $atributosCatacion]);
    }

    #[Route(path: '/{id}/edit', name: 'atributosCatacion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, atributosCatacion $atributosCatacion, AtributosCatacionManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'atributosCatacion_index');
        $form = $this->createForm(AtributosCatacionType::class, $atributosCatacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($atributosCatacion)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('atributosCatacion_index', ['id' => $atributosCatacion->getId()]);
        }

        return $this->render(
            'atributosCatacion/edit.html.twig',
            [
                'atributosCatacion' => $atributosCatacion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'atributosCatacion_delete', methods: ['POST'])]
    public function delete(Request $request, atributosCatacion $atributosCatacion, AtributosCatacionManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'atributosCatacion_index');
        if ($this->isCsrfTokenValid('delete' . $atributosCatacion->getId(), $request->request->get('_token'))) {
            $atributosCatacion->changeActivo();
            if ($manager->save($atributosCatacion)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('atributosCatacion_index');
    }

    #[Route(path: '/{id}/delete', name: 'atributosCatacion_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, atributosCatacion $atributosCatacion, AtributosCatacionManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'atributosCatacion_index', $atributosCatacion);
        if ($this->isCsrfTokenValid('delete_forever' . $atributosCatacion->getId(), $request->request->get('_token'))) {
            if ($manager->remove($atributosCatacion)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('atributosCatacion_index');
    }
}
