# Senior Code Challengue
[![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/bpato/senior_code_challengue)

![Senior Code Challengue](https://github.com/bpato/senior_code_challengue/blob/master/senior_code_challengue.png?raw=true)

## Breve descripción del proyecto

Esta aplicación es un ejemplo de api desacoplada con la funcionalidad de un sistema de carrito de compras. 
Esta implementada siguiendo una arquitectura hexagonal, aplicando un diseño CQRS y DDD y siguiendo los principios solid.

Permite crear carritos, agregar y modificar items, y establecer órdenes de compra.

Los carritos no tienen persistencia en base de datos, están almacenados en cache con un tiempo de vida de 24h o hasta que se realiza su borrado.

Se implementa CQRS con handlers específicos para comandos y consultas, separados de la lógica de infraestructura.

Se implementa un ejemplo de eventos y subscribers con comunicación entre contextos, al momento de establecer un order se comunica desde el contexto del checkout y en el contexto de Cart se elimina el carrito correspondiente.

Se han generado diferentes DTO para mostrar y enriquecer la respuesta de la api con información más completa a la estrictamente necesaria para el trabajo de los modelos del domino.


\
Ejemplo del json de respuesta del carrito:
```json
    {
        "cart": {
            "id": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
            "items": [
                {
                    "product_id": 0,
                    "quantity": 0,
                    "name": "string",
                    "unit_price": 0,
                    "price": 0
                }
            ],
            "total_items": 0,
            "total_price": 0
        }
    }
```

\
Ejemplo del json de respuesta de un pedido:
```json
    {
    "order": {
            "id": 0,
            "cart_reference": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
            "email": "user@example.com",
            "total_price": 0,
            "total_items": 0,
            "created_at": "2025-06-19T14:23:24.696Z",
            "products": [
                {
                    "product_id": 0,
                    "name": "string",
                    "unit_price": 0,
                    "total_price": 0,
                    "quantity": 0
                }
            ]
        }
    }
```

---

## OpenAPI Specification

La especificación OpenAPI se encuentra en el archivo `/docs/openapi.yaml`. Describe todos los endpoints disponibles, los parámetros, las cabeceras, los esquemas de request y response, así como los posibles errores HTTP.

Para visualizarla, podés usar herramientas como [Swagger UI](https://swagger.io/tools/swagger-ui/) o [Redoc](https://github.com/Redocly/redoc).

---

## Modelado del dominio

La estructura establece dos contextos principales `Cart` y `Checkout`

`Cart` engloba todos los casos de uso relativos a la gestión del carrito añadir, actualizar y eliminar items.
El dominio cuenta con las siguientes entidades:

    Cart
    - id
    - items (CartItem[])

    CartItem
    - product_id
    - quantity

`Checkout` engloba los casos de uso relativos a la creación del pedido desde un carrito
El dominio cuenta con las siguientes entidades:

    Order
    - id
    - cart_reference
    - email
    - crated_at
    - total_price
    - total_quantity
    - products (OrderProduct[])

    OrderProduct
    - id
    - product_id
    - name
    - price
    - quantity
    - total_price

    Product
    - id
    - name
    - price

---

## Tecnología utilizada

- PHP 8.3  
- Symfony 7.3  
- Doctrine ORM (solo para entidades persistentes, no para carrito en cache)  
- Messenger Component para mensajería interna  
- PHPUnit para testing  
- Faker para generación de datos de prueba
- Fixture para generar 100 productos de prueba en BD  
- Docker & Docker Compose para el entorno de desarrollo

---

## Levantar el entorno

Para levantar la aplicación con Docker, ejecutar:

```bash
    # levantar el proyecto
    # automaticamente genera ya los migratios y puebla la bd
    docker-compose up -d

    ## apaga el proyecto y elimina los contenedores para que se cree la bd sin problemas
    docker-compose down -v

    ## ejecutar los test
    docker-compose exec -it application_app php /var/www/app/bin/phpunit

```


