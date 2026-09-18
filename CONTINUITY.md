# CONTINUIDAD IPZStream — base XUI clásica

## Estado base — 2026-09-18

IPZStream pasa a desarrollarse directamente sobre la estructura existente de este repositorio, conservando como referencia visual y operativa el panel clásico actual.

### Respaldo inmutable de referencia
- Rama: `backup/original-xui-before-ipzstream-2026-09-18`
- La rama `main` será la línea activa de modernización.

### Regla de trabajo
1. Actualizar CONTINUITY.md antes de cada etapa.
2. Registrar la etapa en BITACORA.md antes de modificar componentes funcionales.
3. Crear respaldo antes de cambios estructurales importantes.
4. Conservar inicialmente navegación, densidad visual, tablas, formularios, iconografía y flujo operativo del panel clásico.
5. Modernizar por debajo de la interfaz: compatibilidad, seguridad, dependencias, streaming, base de datos, instalador y actualizador.
6. No depender de mecanismos de licencia heredados ni de componentes binarios antiguos cuando exista una alternativa mantenible.
7. No copiar hacia otro frontend: este repositorio es ahora la base de trabajo.

## Inventario inicial confirmado

### Administración
El árbol `admin/` contiene Dashboard, Streams, creación individual y masiva, categorías, ordenamiento, revisión, herramientas, EPG, bouquets, líneas, usuarios, MAG/Enigma, películas, series, radio, servidores, conexiones, logs, backups, cache, perfiles, proveedores, proxies y configuración.

### Núcleo
`includes/` contiene la lógica histórica principal, APIs, streaming, PDO, CLI y librerías.

### Entrega IPTV
`www/` contiene endpoints de API/player, playlist, EPG, Enigma2 y streaming.

### Reproductor
`player/` mantiene interfaz propia para Live, películas, series, episodios y perfil.

### Reseller
`reseller/` mantiene dashboard y administración delegada de líneas, usuarios, dispositivos, contenido y conexiones.

### Runtime heredado
`bin/` contiene FFmpeg, Nginx, nginx-rtmp, PHP, Redis y otros binarios/utilidades empaquetados. Se consideran legado y deberán auditarse antes de decidir su sustitución.

## ETAPA 1 — Congelación e inventario [EN CURSO]

Objetivo: convertir el panel existente en una base controlada de IPZStream sin cambiar todavía su apariencia.

Alcance:
- preservar el panel clásico y reproductor;
- documentar arquitectura y módulos;
- identificar runtime heredado y dependencias críticas;
- preparar una ruta de compatibilidad Ubuntu 24.04;
- separar interfaz/funciones que se mantienen de componentes internos que serán reemplazados;
- definir migración incremental para evitar una reescritura visual.

Siguiente subetapa: auditar arranque, configuración, base de datos, PHP/runtime, Nginx, Redis y FFmpeg antes de modificar el funcionamiento.


## ETAPA 1.1 — Auditoría de arranque/runtime — COMPLETADA

Hallazgos confirmados en el código actual:
- `service` fija `/home/xui`, usuario `xui` y arranca Redis, Nginx, nginx-rtmp, PHP-FPM y varios workers CLI desde binarios empaquetados.
- El arranque ejecuta `startup.php`, `signals.php`, `watchdog.php`, `queue.php` y, cuando existen, `cache_handler.php` y `connection_sync.php`.
- `bin/daemons.sh` levanta cuatro pools PHP-FPM propios desde `/home/xui/bin/php`.
- `update` depende del servicio systemd `xuione`, extrae paquetes tar sobre la instalación y ejecuta el post-update histórico.
- El runtime incluye Redis propio, Nginx propio, nginx-rtmp, PHP propio y árboles FFmpeg 4.0/4.3/4.4.
- `bin/install/database.sql` conserva el esquema histórico de instalación.

### Decisión
No se sustituirá el runtime en bloque. La modernización será por capas para mantener el panel funcionando y visualmente intacto.

Orden técnico:
1. crear un bootstrap/diagnóstico IPZStream no destructivo para Ubuntu 24.04;
2. inventariar versión/compatibilidad de binarios sin ejecutarlos durante el desarrollo;
3. desacoplar gradualmente `sudo` y rutas rígidas del script `service`;
4. mantener esquema y UI mientras se valida cada sustitución;
5. abordar actualizador/licencia heredados como componentes separados, sin romper autenticación ni panel.
