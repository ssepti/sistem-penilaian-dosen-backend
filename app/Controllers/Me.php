<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use App\Models\UserModel;

class Me extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    use ResponseTrait;
    public function index()

    {
        //
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if(!$header) return $this->failUnauthorized('Token Required');
        $token = explode(' ', $header)[1];

        try {
    $decoded = JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
    $response = [
        'id' => $decoded->uid,
        'email' => $decoded->email
    ];
    return $this->respond($response);
} catch (\Throwable $th) {
    return $this->fail('Invalid Token: ' . $th->getMessage());
}

    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
