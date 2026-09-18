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
