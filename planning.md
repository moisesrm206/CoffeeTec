# CoffeeTec — Plan de funcionalidades

> Documento de planeación basado en el estado del proyecto al 13 de noviembre de 2026.
> Objetivo: **demo escolar / presentación**, panel de administración propio con **Blade + Tailwind** y **pago simulado en caja**.

---

## 1. Estado actual del proyecto

CoffeeTec es un prototipo de cafetería escolar construido con Laravel 13, PHP 8.5, Tailwind 4 y PostgreSQL (Supabase).

### Lo que ya funciona

- **Menú público** (`/`, `/menu`): listado de productos por categoría, filtro por categoría, búsqueda y carrito en JavaScript.
- **Creación de pedidos** (`POST /pedidos`): valida nombre y productos, recalcula el total en el servidor y guarda la orden en una transacción.
- **Panel de cocina** (`/cocina`): tablero de 3 columnas (`pending`, `making`, `completed`) con cambio de estado.
- **Modelos y migraciones**: `categories`, `products`, `orders`, `order_products` con claves primarias propias (`id_category`, `id_product`, `id_order`, `id_order_product`).
- **Estilos**: Bootstrap 5 por CDN + Tailwind 4 (configurado pero casi sin uso).

### Huecos críticos detectados

1. **El stock nunca se descuenta ni se valida.** Se pueden pedir 100 piezas de un producto con stock 20 y el inventario queda intacto. El menú solo oculta productos con `stock = 0`.
2. **No hay autenticación ni autorización.** Cualquier persona puede abrir `/cocina`, ver nombres de clientes y cambiar estados.
3. **No hay CRUD.** `ProductController` y `CategoryController` tienen todos los métodos vacíos; los datos solo existen vía seeder.
4. **Validación débil del pedido.** Los ítems llegan como JSON en un `input hidden`, sin Form Request, sin límite de cantidad y sin control de duplicados.
5. **Ciclo de pedido incompleto.** El enum soporta `delivered` y `cancelled`, pero la UI no los usa; cancelar no devuelve stock y no hay timestamps de estado.
6. **Bug de importación:** `CategoryController.php` importa `App\Models\category` en minúscula; falla en sistemas sensibles a mayúsculas (Linux/servidor).
7. **Sin tests de funcionalidad ni factories.** Solo existen los tests de ejemplo del esqueleto.
8. **Sin índices** en `orders.status` ni `orders.created_at` (se consultan en cada carga de cocina).

---

## 2. Decisiones de alcance

| Decisión | Elección | Motivo |
|---|---|---|
| Objetivo | Demo escolar / presentación | Flujo completo y vistoso, sin infraestructura de producción |
| Panel admin | Blade + Tailwind propio | Sin dependencias nuevas; control total del diseño |
| Estilos | Migrar las vistas de Bootstrap a Tailwind | Un solo sistema de diseño y la demo no depende del CDN |
| Pagos | Simulados (efectivo/tarjeta/transferencia) | Se registra el cobro en caja, sin pasarela |
| Base de datos de demo | SQLite local + seeders | Evitar depender del WiFi del plantel (Supabase es remoto) |

---

## 3. Fase 0 — Correcciones invisibles que salvan la demo (0.5 día)

- Corregir `use App\Models\category` → `Category` en `CategoryController`.
- **Validar y descontar stock** con transacción y `lockForUpdate`. Evitar stock negativo y devolver un mensaje claro en la UI.
- Crear `StoreOrderRequest`:
  - Validar IDs y cantidades (1–20).
  - Verificar stock disponible.
  - Enviar solo `id` + `quantity` desde el carrito (el total ya se recalcula en el servidor).
- Agregar índices en `orders.status` y `orders.created_at`.
- Crear factories de los 4 modelos y 5 tests de feature:
  - Pedido válido.
  - Stock insuficiente.
  - Transición de estado válida.
  - Acceso denegado sin sesión.
  - Generación de folio.

---

## 4. Fase 1 — Flujo completo de demo (2–3 días)

1. **Login de personal mínimo**
   - Tabla `users`, inicio de sesión con `Auth::attempt`.
   - Seeder con `cocina@coffeetec.test`.
   - Middleware `auth` en `/cocina` y `/admin`.
   - Sin Breeze, para mantenerlo simple.

2. **Panel `/admin` (Blade + Tailwind)**
   - Productos: listado con búsqueda y paginación, crear/editar, activar/desactivar, subida de imagen (`storage:link`), Form Requests.
   - Categorías: CRUD con regla "no borrar si tiene productos".

3. **Pedidos con folio**
   - Folio legible: `CT-0001`.
   - Tabla `order_status_histories` para registrar cada transición.
   - Estados: pendiente → preparando → listo → entregado / cancelado.

4. **Cocina mejorada**
   - 4 columnas (incluye entregados) y acción de cancelar.
   - Cancelar devuelve el stock.
   - Auto-refresco cada 5 segundos, aviso sonoro y contador de pendientes.

5. **Cobro en caja**
   - Campos `payment_method` y `paid_at`.
   - Botón "Cobrar" con ticket imprimible (`window.print()`).

6. **Seguimiento público del pedido**
   - Ruta `/pedido/{folio}` sin autenticación.
   - El alumno consulta en qué estado va su pedido.

---

## 5. Fase 2 — Métricas para la presentación (1–2 días)

- **Dashboard** con Eloquent, sin paquetes externos:
  - Ventas del día.
  - Pedidos del día.
  - Ticket promedio.
  - Top 5 productos.
  - Pedidos por estado.
- **Reporte por rango de fechas** con exportación a CSV.
- **Seeder realista**: 10 productos y 20 pedidos repartidos en la semana para que el dashboard no salga vacío.

---

## 6. Fase 3 — Opcionales (fuera del alcance de la demo)

- Disponibilidad por horario y menú del día.
- Cupones y promociones.
- PWA / funcionamiento offline.
- Aviso de "pedido listo" por WhatsApp o push.
- Cuentas de cliente con historial y "reordenar".
- API REST versionada con Eloquent Resources.

---

## 7. Orden de implementación

| # | Entrega | Tiempo estimado |
|---|---|---|
| 1 | Fix categoría + stock atómico + Form Request + tests | 0.5 día |
| 2 | Migración de vistas a Tailwind + layout base | 0.5–1 día |
| 3 | Login de personal + protección de rutas | 0.5 día |
| 4 | CRUD de productos y categorías | 1 día |
| 5 | Folio + historial de estados + cocina con polling y sonido | 1 día |
| 6 | Cobro + ticket + seguimiento público | 1 día |
| 7 | Dashboard + reportes + seeder demo | 1 día |
| 8 | SQLite local + comando `demo:reset` + ensayo completo | 0.5 día |

**Total estimado:** 5.5 – 7 días de trabajo.

---

## 8. Riesgos y mitigaciones

| Riesgo | Mitigación |
|---|---|
| Stock negativo o inventario inconsistente | Transacción + `lockForUpdate` + validación en Form Request (Fase 0) |
| Doble envío del formulario (doble clic) | Token de idempotencia o deshabilitar el botón tras enviar |
| La demo falla por falta de internet | SQLite local + assets compilados con Vite (sin CDN) |
| Dashboard vacío durante la presentación | Seeder con pedidos históricos (Fase 2) |
| Cambios de estado no autorizados | Middleware `auth` + roles (Fase 1) |
| Datos sensibles expuestos | `.env` está en `.gitignore`; no mostrar credenciales en capturas |

---

## 9. Definición de "terminado" para la demo

- [ ] Se puede pedir sin exceder el stock y el inventario baja correctamente.
- [ ] Nadie sin sesión puede entrar a `/cocina` ni a `/admin`.
- [ ] Se puede crear, editar, desactivar y borrar un producto y una categoría.
- [ ] Un pedido recorre pendiente → preparando → listo → entregado, y se puede cancelar.
- [ ] Cancelar un pedido restaura el stock.
- [ ] Se puede cobrar un pedido e imprimir su ticket.
- [ ] El alumno puede consultar su pedido por folio.
- [ ] El dashboard muestra métricas con datos de ejemplo.
- [ ] La aplicación funciona sin conexión a internet.
- [ ] `php artisan test` pasa en verde.
