<?php

namespace event;

class RequestHandler {
    public function getJSONBody(): null|object
    {
        return json_decode(file_get_contents("php://input"));
    }
}