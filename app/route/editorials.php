<?php
use App\Model\Editorial;

$app->group('/editors/', function () {

    $this->get('', function ($req, $res, $args) {
        $obj = new \App\Model\Editorial();
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