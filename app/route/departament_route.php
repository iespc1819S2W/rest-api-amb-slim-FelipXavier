<?php
use App\Model\Departament;

$app->group('/departament/', function () {

    $this->get('', function ($req, $res, $args) {
        $obj = new Departament();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->getAll()
                )
            );
    });
});