<?php

use App\Model\Colleccio;

$app->group('/collecio/', function () {

    $this->get('', function ($req, $res, $args) {
        $obj = new Colleccio();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->getAll()
                )
            );
    });

    $this->post('', function ($req, $res, $args) {
        $atributs = $req->getParsedBody();  //llista atributs del client
        $obj = new Colleccio();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->insert($atributs)
                )
            );
    });

    $this->get('cerca/{q}', function ($req, $res, $args) {
        $obj = new Colleccio();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->getQuery($args["q"])
                )
            );
    });


});