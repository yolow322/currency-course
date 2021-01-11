<?php

namespace App\Core;

class Application
{
    public static Application $app;

    public Router $router;

    public Request $request;

    public Response $response;

    public DataBase $dataBase;

    public function __construct(array $envConfig)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->response = new Response();
        $this->dataBase = new DataBase($envConfig['db']);
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {
            $this->response->setStatusCode($exception->getCode());
            View::render('error', [
               'exception' => $exception
            ]);
        }
    }
}