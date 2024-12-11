### Schnell

Schnell (meaning 'fast' in German) is the PHP micro framework that use most of the Slim framework components.

#### Run locally

```bash
php -S localhost:8080 -t ./
```

#### Creating a controller

All declared controller must be:
- extends ```Schnell\Controller\AbstractController```
- have ```$request```, ```$response```, and ```$args``` in route invokable method, where each of that are:
  - ```$request``` must be an instance of ```Psr\Http\Message\RequestInterface```
  - ```$response``` must be an instance of ```Psr\Http\Message\ResponseInterface```
  - ```$args``` must be an array
