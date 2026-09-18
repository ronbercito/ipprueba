# BITÁCORA IPZStream — base XUI clásica

## 2026-09-18 — Inicio de nueva base

Se adopta `ronbercito/ipprueba` como base activa del nuevo IPZStream.

Respaldo creado antes de modificaciones:
`backup/original-xui-before-ipzstream-2026-09-18`

### Etapa 1 autorizada — Congelación e inventario

Se confirma mediante inventario del repositorio que la base contiene el panel administrativo completo, área reseller, reproductor web, endpoints IPTV y runtime histórico empaquetado.

Decisión de arquitectura:
- mantener inicialmente el aspecto y flujo del panel existente;
- trabajar directamente sobre esta base;
- no reconstruir la interfaz en el frontend React anterior;
- modernizar de forma incremental los componentes internos;
- priorizar Ubuntu 24.04 y dependencias mantenibles;
- mantener Streams/Channels, reproductor, iconos, tablas, formularios y navegación reconocibles durante la migración.

### Hallazgos iniciales
- `admin/`: panel y módulos operativos.
- `includes/`: núcleo histórico y streaming.
- `www/`: APIs y entrega IPTV.
- `player/`: reproductor Live/VOD/Series.
- `reseller/`: panel reseller.
- `bin/`: runtime legado empaquetado, incluyendo FFmpeg, Nginx, nginx-rtmp, PHP y Redis.

Estado: documentación base publicada. No se ha alterado todavía el comportamiento del panel clásico.

Próximo trabajo: auditoría técnica del arranque/runtime y diseño de sustitución segura para Ubuntu 24.04.


## 2026-09-18 — Etapa 1.1: auditoría runtime

Revisados `service`, `update`, `bin/daemons.sh`, `includes/cli/` y los árboles de runtime.

Hallazgos:
- servicio monolítico basado en `/home/xui` y usuario `xui`;
- Redis/Nginx/nginx-rtmp/PHP-FPM empaquetados;
- cuatro pools PHP-FPM;
- workers CLI de startup, señales, watchdog, cola y cache;
- actualizador histórico acoplado a `xuione`;
- FFmpeg empaquetado en ramas 4.0, 4.3 y 4.4;
- esquema de instalación histórico disponible en `bin/install/database.sql`.

No se modificó ningún componente operativo. Se mantiene intacta la UI clásica.

Próximo cambio autorizado: añadir herramientas propias de diagnóstico/compatibilidad IPZStream que sean no destructivas y no alteren el arranque XUI existente.


### Herramienta propia añadida
Se añadió `ipzstream-compat-audit.sh`, auditor de solo lectura para OS, kernel, arquitectura, comandos del sistema, runtime empaquetado y rutas esenciales. No inicia/detiene servicios ni modifica archivos. Nota: el nombre `tools` ya existe como archivo en la raíz histórica, por eso el auditor se mantiene en la raíz.
