<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Socio;
use Pidia\Apps\Demo\Form\SocioType;
use Pidia\Apps\Demo\Manager\SocioManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/socio')]
class SocioController extends BaseController
{
    #[Route(path: '/', name: 'socio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'socio_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, SocioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'socio_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'socio/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'socio_export', methods: ['GET'])]
    public function export(Request $request, SocioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'socio_index');
        $headers = [
            'fechaIngreso' => 'Fecha Ingreso',
            'codigo' => 'Codigo',
            'tipo' => 'Tipo',
            'nombres' => 'Nombres',
            'apellidoPaterno' => 'Apellido Paterno',
            'apellidoMaterno' => 'Apellido Materno',
            'sexo' => 'Sexo',
            'numeroDocumento' => 'Numero Documento',
            'telefono' => 'Telefono',
            'fechaNacimiento' => 'Fecha Nacimiento',
            'conyuqueNombre' => 'Conyugue Nombre',
            'conyugueDocumento' => 'Conyugue Documento',
            'ruc' => '',
            'estadoRuc' => 'Estado Ruc',
            'estado' => 'Estado',
            'activo' => 'Activo',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var Socio $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['fechaIngreso'] = $objeto->getFechaIngreso();
            $item['codigo'] = $objeto->getCodigo();
            $item['tipo'] = $objeto->getTipo();
            $item['nombres'] = $objeto->getNombres();
            $item['apellidoPaterno'] = $objeto->getApellidoPaterno();
            $item['apellidoMaterno'] = $objeto->getApellidoMaterno();
            $item['sexo'] = $objeto->getSexo();
            $item['numeroDocumento'] = $objeto->getNumeroDocumento();
            $item['telefono'] = $objeto->getTelefono();
            $item['fechaNacimiento'] = $objeto->getFechaNacimiento();
            $item['conyugueNombre'] = $objeto->getConyugueNombre();
            $item['conyugueDocumeto'] = $objeto->getConyugueDocumento();
            $item['ruc'] = $objeto->getRuc();
            $item['estadoRuc'] = $objeto->getEstadoRuc();
            $item['estado'] = $objeto->getEstado();
            $item['activo'] = $objeto->activo();
            $data[] = $item;
            unset($item);
        }

        return $manager->export($data, $headers, 'Reporte');
    }

    #[Route(path: '/new', name: 'socio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocioManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'socio_index');
        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $socio->setPropietario($this->getUser());
            if ($manager->save($socio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('socio_index');
        }

        return $this->render(
            'socio/new.html.twig',
            [
                'socio' => $socio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'socio_show', methods: ['GET'])]
    public function show(Socio $socio): Response
    {
        $this->denyAccess(Access::VIEW, 'socio_index');

        return $this->render('socio/show.html.twig', ['socio' => $socio]);
    }

    #[Route(path: '/{id}/edit', name: 'socio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Socio $socio, SocioManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'socio_index');
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($socio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('socio_index', ['id' => $socio->getId()]);
        }

        return $this->render(
            'socio/edit.html.twig',
            [
                'socio' => $socio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'socio_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio, SocioManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'socio_index');
        if ($this->isCsrfTokenValid('delete'.$socio->getId(), $request->request->get('_token'))) {
            $socio->changeActivo();
            if ($manager->save($socio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('socio_index');
    }

    #[Route(path: '/{id}/delete', name: 'socio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Socio $socio, SocioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'socio_index', $socio);
        if ($this->isCsrfTokenValid('delete_forever'.$socio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($socio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('socio_index');
    }
}
