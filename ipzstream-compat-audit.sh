#!/bin/sh
# IPZStream compatibility audit — read-only.
set -u
BASE="${IPZSTREAM_HOME:-/home/xui}"
say(){ printf '%-28s %s\n' "$1" "$2"; }
cmd(){ command -v "$1" 2>/dev/null || true; }
ver(){ if [ -x "$1" ]; then out=$("$1" --version 2>&1 | head -n 1 || true); [ -n "$out" ] || out="present"; printf '%s' "$out"; else printf '%s' "missing"; fi; }
echo "IPZStream compatibility audit"
echo "============================="
say "Base" "$BASE"
if [ -r /etc/os-release ]; then . /etc/os-release; say "OS" "${PRETTY_NAME:-unknown}"; else say "OS" "unknown"; fi
say "Kernel" "$(uname -sr 2>/dev/null || echo unknown)"
say "Architecture" "$(uname -m 2>/dev/null || echo unknown)"
say "User" "$(id -un 2>/dev/null || echo unknown)"
echo
echo "System commands"
for x in systemctl start-stop-daemon ffprobe ffmpeg nginx redis-server php mariadb mysql python3; do p=$(cmd "$x"); say "$x" "${p:-missing}"; done
echo
echo "Legacy runtime"
say "XUI service script" "$([ -f "$BASE/service" ] && echo present || echo missing)"
say "Bundled PHP" "$(ver "$BASE/bin/php/bin/php")"
say "Bundled Redis" "$(ver "$BASE/bin/redis/redis-server")"
say "Bundled Nginx" "$(ver "$BASE/bin/nginx/sbin/nginx")"
say "Bundled nginx-rtmp" "$(ver "$BASE/bin/nginx_rtmp/sbin/nginx_rtmp")"
for v in 4.0 4.3 4.4; do f="$BASE/bin/ffmpeg_bin/$v/ffmpeg"; [ -x "$f" ] || f="$BASE/bin/ffmpeg_bin/$v/ffmpeg_bin"; say "Bundled FFmpeg $v" "$(ver "$f")"; done
echo
echo "Required paths"
for p in admin includes includes/cli www player reseller content tmp; do [ -e "$BASE/$p" ] && state=present || state=missing; say "$p" "$state"; done
echo
echo "Audit complete. No changes were made."
