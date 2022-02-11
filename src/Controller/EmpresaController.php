<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Empresa;
use Pidia\Apps\Demo\Form\EmpresaType;
use Pidia\Apps\Demo\Manager\EmpresaManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/empresa')]
class EmpresaController extends BaseController
{
    #[Route(path: '/', name: 'empresa_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'empresa_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EmpresaManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'empresa_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'empresa/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'empresa_export', methods: ['GET'])]
    public function export(Request $request, EmpresaManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'empresa_index');
        $headers = [
            'nombre' => 'Nombre',
            'ruc' => 'Ruc',
            'direccion' => 'Direccion',
            'gmail' => 'Gmail',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var empresa $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombre'] = $objeto->getNombre();
            $item['Ruc'] = $objeto->getRuc();
            $item['direccion'] = $objeto->getDireccion();
            $item['gmail'] = $objeto->getGmail();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte', 'empresa');
    }

    #[Route(path: '/new', name: 'empresa_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmpresaManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'empresa_index');
        $empresa = new empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $empresa->setPropietario($this->getUser());
            if ($manager->save($empresa)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('empresa_index');
        }

        return $this->render(
            'empresa/new.html.twig',
            [
                'empresa' => $empresa,
                'form' => $form->createView(),
            ]
        );
    }
    
    #[Route(path: '/{id}', name: 'empresa_show', methods: ['GET'])]
    public function show(empresa $empresa): Response
    {
        $this->denyAccess(Access::VIEW, 'empresa_index');

        return $this->render('empresa/show.html.twig', ['empresa' => $empresa]);
    }

    #[Route(path: '/{id}/edit', name: 'empresa_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, empresa $empresa, EmpresaManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'empresa_index');
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($empresa)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('empresa_index', ['id' => $empresa->getId()]);
        }

        return $this->render(
            'empresa/edit.html.twig',
            [
                'empresa' => $empresa,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'empresa_delete', methods: ['POST'])]
    public function delete(Request $request, empresa $empresa, EmpresaManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'empresa_index');
        if ($this->isCsrfTokenValid('delete'.$empresa->getId(), $request->request->get('_token'))) {
            $empresa->changeActivo();
            if ($manager->save($empresa)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('empresa_index');
    }

    #[Route(path: '/{id}/delete', name: 'empresa_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, empresa $empresa, EmpresaManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'empresa_index', $empresa);
        if ($this->isCsrfTokenValid('delete_forever'.$empresa->getId(), $request->request->get('_token'))) {
            if ($manager->remove($empresa)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('empresa_index');
    }
}
