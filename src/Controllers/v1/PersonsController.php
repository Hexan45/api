<?php

namespace src\Controllers\v1;

use core\MVC\Controller;
use core\MVC\Validation\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PersonsController extends Controller
{

    public function getAll(Request $request, Response $response, array $args) : Response
    {
        $personsModel = $this->makeModel('v1\\Persons');
        $payload = $personsModel->all();

        $response->getBody()->write(json_encode($payload));

        return $response->withStatus(200);
    }

    public function getSingle(Request $request, Response $response, array $args) : Response
    {
        $personsModel = $this->makeModel('v1\\Persons');

        $payload = $personsModel->find(['id', '=', ':id'], [':id' => $args['personID']]);

        if ($payload === false)
        {
           $payload = [
               'success' => 'false',
               'message' => 'Person with ' . $args['personID'] . ' ID not exists'
           ];

           $response->getBody()->write(json_encode($payload));
           return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($payload));
        return $response->withStatus(200);
    }

    public function storageData(Request $request, Response $response, array $args) : Response
    {
        $personsModel = $this->makeModel('v1\\Persons');

        $validator = new Validator($request->getParsedBody(), [
           'firstName' => 'required|min:3|max:20',
           'lastName' => 'required|min:3|max:30',
           'age' => 'required|min:1|max:3|integer',
           'companyId' => 'required|integer',
           'birthDate' => 'required'
        ]);

        $validator->validate();

        if($validator->hasErrors())
        {
            $payload = $validator->getFirstErrors();
            $response->getBody()->write(json_encode($payload));

            return $response->withStatus(400);
        }

        $validated = $validator->validated();

        foreach($validated as $key => $value)
        {
            $personsModel->$key = $value;
        }

        if ($personsModel->save())
        {
            $payload = [
                'success' => 'true',
                'message' => 'Created new person in table',
                'newPerson' => $validated
            ];

            $response->getBody()->write(json_encode($payload));
            return $response->withStatus(201);
        }

        $payload = [
            'success' => 'false',
            'message' => 'Internal Server Error'
        ];
        $response->getBody()->write(json_encode($payload));
        return $response->withStatus(500);
    }

    public function updateSingle(Request $request, Response $response, array $args) : Response
    {
        $persons = $this->makeModel('v1\\Persons', $args['personID']);

        $validator = new Validator($request->getParsedBody(), [
            'firstName' => 'min:3|max:20',
            'lastName' => 'min:3|max:20',
            'age' => 'min:1|max:3|integer',
            'companyId' => 'integer',
            'birthDate' => 'date'
        ]);

        $validator->validate();

        if ($validator->hasErrors())
        {
            $payload = $validator->getFirstErrors();

            $response->getBody()->write(json_encode($payload));
            return $response->withStatus(400);
        }

        $validated = $validator->validated();
        foreach($validated as $key => $value)
        {
            $persons->$key = $value;
        }

        if ($persons->update() === false)
        {
            $payload = [
                'success' => 'false',
                'message' => 'Internal Server Error'
            ];

            $response->getBody()->write(json_encode($payload));
            return $response->withStatus(500);
        }
        $payload = [
            'success' => 'true',
            'message' => 'Succesfully updated person in database',
            'person' => [
                'firstName' => $persons->first_name,
                'lastName' => $persons->last_name,
                'age' => $persons->age,
                'companyId' => $persons->company_id,
                'birthDate' => $persons->birth_date
            ]
        ];

        $response->getBody()->write(json_encode($payload));
        return $response->withStatus(200);
    }

    public function deleteSingle(Request $request, Response $response, array $args) : Response
    {
        $persons = $this->makeModel('v1\\Persons', $args['personID']);

        if ($persons->delete() === false)
        {
            $payload = [
                'success' => 'false',
                'message' => 'Internal Server Error'
            ];

            $response->getBody()->write(json_encode($payload));
            return $response->withStatus(500);
        }

        $payload = [
            'success' => 'true',
            'message' => 'Successfully deleted person from database',
            'person' => [
                'firstName' => $persons->first_name,
                'lastName' => $persons->last_name,
                'age' => $persons->age,
                'companyId' => $persons->company_id,
                'birthDate' => $persons->birth_date
            ]
        ];

        $response->getBody()->write(json_encode($payload));
        return $response->withStatus(200);
    }

}