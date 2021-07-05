<?php


namespace Src\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use Src\Http\Middleware\Queue;

class Router
{
    /**
     * URL completa do projeto (raiz)
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instancia de Request
     * @var Request
     */
    private $request;

    /**
     * Método responsavel por iniciar a classe
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->request = new Request($this);
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * Método responsavel por definir o prefixo das rotas
     */
    public function setPrefix()
    {
        //Informações da URL atual
        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsavel por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute(string $method, string $route, array $params = [])
    {
        //Validação dos Parametros
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //Middlewares da rota
        $params['middlewares'] = $params['middlewares'] ?? [];

        //Variaveis da rota
        $params['variables'] = [];

        //Padrao de validação das variaveis das rotas
        $paternVariable = '/{(.*?)}/';
        if (preg_match_all($paternVariable, $route, $matches)) {
            $route               = preg_replace($paternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //Padrão de validação da URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';


        //Adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;

    }

    /**
     * Método responsavel por definir uma rota de GET
     * @param string $route
     * @param array $params
     */
    public function get(string $route, array $params = [])
    {
        $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsavel por definir uma rota de POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsavel por definir uma rota de PUT
     * @param string $route
     * @param array $params
     */
    public function put(string $route, array $params = [])
    {
        $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsavel por definir uma rota de DELETE
     * @param string $route
     * @param array $params
     */
    public function delete(string $route, array $params = [])
    {
        $this->addRoute('DELETE', $route, $params);
    }

    /**
     * Método responsavel por retornar a URI desconsiderando o prefixo
     * @return string
     */
    private function getUri(): string
    {
        //URI da Request
        $uri = $this->request->getUri();

        //Fatia a URI com o Prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //Retorna a URI sem o prefixo
        return end($xUri);
    }

    /**
     * Método responsavel por retornar a rota atual
     * @return array
     */
    private function getRoute(): array
    {
        //Retornar a URI
        $uri = $this->getUri();

        //Método
        $httpMethod = $this->request->getHttpMethod();

        //valida as rotas
        foreach ($this->routes as $patternRoute => $methods) {
            //Verifica se a URI bate o padrão
            if (preg_match($patternRoute, $uri, $matches)) {
                //Verifica o método
                if ($methods[$httpMethod]) {
                    //Remove a primeira posição
                    unset($matches[0]);

                    //Variaveis processadas
                    $keys                                         = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables']            = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //Retorna os parametros da rota
                    return $methods[$httpMethod];
                }
                //Método não permitido
                throw new Exception('Método não permitido', 405);
            }
        }
        //URL não encontrada
        throw new Exception('URL não encontrada', 404);
    }

    /**
     * Método responsavel por executar a rota atual
     * @return Queue|Response
     */
    public function run()
    {
        try {
            $route = $this->getRoute();

            //Verifica o Controlador
            if (!isset($route['controller'])) {
                throw new Exception('A URL nao pode ser processada', 500);
            }

            //Argumentros da função
            $args = [];

            //Reflection
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name        = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //Retorna a Execução da fila de middlewares
            return (new Queue($route['middlewares'], $route['controller'], $args))->next($this->request);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Método responsável por retornar a URL atual
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->url . $this->getUri();
    }

    /**
     * Método responsavel por redirecionar a URL
     * @param string $route
     */
    public function redirect(string $route)
    {
        //URL
        $url = $this->url.$route;

        //Executa o redirect
        header('location: '.$url);
        exit;

    }
}