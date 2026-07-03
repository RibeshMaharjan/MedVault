# Toast Notifications

Superseded by the UI redesign (see `UI_REDESIGN_PLAN.md`). The `proj-front/` paths this
document originally described no longer exist.

Current implementation:
- Server flash messages are set via `Session::flash($message, $type)` (`app/Core/Session.php`)
  and rendered by `alertMessage()` in `app/Helpers/functions.php`.
- Markup/styling lives in `public/assets/css/components.css` (`.toast`, `.toast-container`).
- Client behavior (auto-dismiss, close button, `window.toast()` for JS-triggered toasts)
  lives in `public/assets/js/ui.js`.
