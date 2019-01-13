<?php


namespace App\Controllers;
use App\Models\Entities\Contact;
use App\Models\Mappers\ContactMapper;


class ContactController
{
    protected $container;
    protected $contactMapper;

    public function __construct($container)
    {
        $this->container = $container;
        $this->contactMapper = $this->container->get(ContactMapper::class);
    }

    public function all($request, $response, $args)
    {
        $contacts = $this->contactMapper->getContacts();
        $dataContacts = array_map(function($contact){ return $contact->toArray(); }, $contacts);
        $responseJson = $response->withJson( $dataContacts , 201);
        return $responseJson;
    }

    public function create($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $entity = new Contact($data);
        $contact = $this->contactMapper->insert($entity);
        $responseJson = $response->withJson($contact->toArray());
        return $responseJson;
    }

    public function edit($request, $response, $args)
    {
        $id  = $args['id'];
        $data = $this->contactMapper->getContact($id);
        $data = array_merge($data->toArray(), $request->getParsedBody());
        $entity = new Contact($data);
        $contact = $this->contactMapper->update($entity);
        $responseJson = $response->withJson($contact->toArray());
        return $responseJson;
    }

    public function show($request, $response, $args)
    {
        $contact = $this->contactMapper->getContact($args['id']);
        $responseJson = $response->withJson($contact->toArray());
        return $responseJson;
    }

    public function delete($request, $response, $args)
    {
        $this->contactMapper->delete($args['id']);
        $json['success'] = 'Registro #'.$args['id'].' removido com sucesso';
        $responseJson = $response->withJson($json);
        return $responseJson;
    }

}