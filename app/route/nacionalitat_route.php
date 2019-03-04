<?php
use App\Model\Nacionalitat;

$app->group('/nacionalitat/', function () {

    $this->get('', function ($req, $res, $args) {
        $obj = new \App\Model\Nacionalitat();
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