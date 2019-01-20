<?php
use App\Model\Llibre;

$app->group('/llibre/', function () {

    $this->get('', function ($req, $res, $args) {
        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->getAll()
                )
            );
    });

    $this->get('{id}', function ($req, $res, $args) {
        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->get($args["id"])
                )
            );
    });

    $this->post('', function ($req, $res, $args) {
        $atributs=$req->getParsedBody();  //llista atributs del client
        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->insert($atributs)
                )
            );
    });

    $this->put('', function ($req, $res, $args) {
        $atributs=$req->getParsedBody();  //llista atributs del client
        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->update($atributs)
                )
            );
    });

    $this->delete('', function ($req, $res, $args) {
        $atributs=$req->getParsedBody();  //llista atributs del client

        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->delete($atributs)
                )
            );
    });


$this->post('autors-llibres/', function ($req, $res, $args) {
    $atributs=$req->getParsedBody();  //llista atributs del client
    $obj = new Llibre();
    return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $obj->insertAutLlib($atributs)
            )
        );
});

    $this->delete('autors-llibres/', function ($req, $res, $args) {
        $atributs=$req->getParsedBody();  //llista atributs del client
        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->deleteAutLlib($atributs)
                )
            );
    });


    $this->get('llibre-autors/{id}', function ($req, $res, $args) {
        $obj = new Llibre();
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->llibreAutors($args["id"])
                )
            );
    });

    $this->get('filtra/{id_llib}/{titol}[/{order}[/{offset}[/{count}]]]', function ($req, $res, $args) {
        $obj = new Llibre();
        $where="{$args["id_llib"]} like '%{$args["titol"]}%'";
        $orderby =(isset($args["order"]) ? $args["order"] : "");
        $offset =(isset($args["offset"]) ? $args["offset"] : "");
        $count =(isset($args["count"]) ? $args["count"] : "");
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $obj->filtra($where,$orderby,$offset,$count)
                )
            );
    });

});
