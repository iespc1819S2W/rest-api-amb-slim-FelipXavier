<?php
use App\Model\Llengua;

$app->group('/llengua/', function () {

    $this->get('', function ($req, $res, $args) {
        $obj = new Llengua();
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
