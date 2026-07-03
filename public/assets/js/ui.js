/*
 * Vanilla-JS behaviors replacing Bootstrap JS: dialogs, dropdowns, tabs,
 * sidebar collapse, toasts, combobox, table sort, confirm dialogs.
 */
(function () {
  "use strict";

  /* ---------- Dialog ---------- */
  document.addEventListener("click", function (e) {
    var openTrigger = e.target.closest("[data-dialog-open]");
    if (openTrigger) {
      var sel = openTrigger.getAttribute("data-dialog-open");
      var dlg = document.querySelector(sel);
      if (dlg && typeof dlg.showModal === "function") {
        var fieldsAttr = openTrigger.getAttribute("data-fields");
        if (fieldsAttr) {
          try {
            var fields = JSON.parse(fieldsAttr);
            Object.keys(fields).forEach(function (name) {
              var el = dlg.querySelector('[name="' + name + '"]');
              if (el) el.value = fields[name] == null ? "" : fields[name];
            });
            var actionAttr = openTrigger.getAttribute("data-form-action");
            if (actionAttr) {
              var form = dlg.querySelector("form");
              if (form) form.setAttribute("action", actionAttr);
            }
          } catch (err) {
            /* ignore malformed JSON */
          }
        }
        dlg.showModal();
      }
      return;
    }

    var closeTrigger = e.target.closest("[data-dialog-close]");
    if (closeTrigger) {
      var owner = closeTrigger.closest("dialog");
      if (owner) owner.close();
      return;
    }

    // backdrop click closes dialog (click landed on <dialog> itself, not its content)
    if (e.target.tagName === "DIALOG") {
      e.target.close();
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("dialog[data-auto-open]").forEach(function (dlg) {
      if (typeof dlg.showModal === "function") dlg.showModal();
    });
  });

  /* ---------- Dropdown / popover ---------- */
  document.addEventListener("click", function (e) {
    var toggle = e.target.closest("[data-dropdown-toggle]");
    if (toggle) {
      var sel = toggle.getAttribute("data-dropdown-toggle");
      var panel = document.querySelector(sel);
      if (panel) {
        var isOpen = panel.classList.contains("is-open");
        document.querySelectorAll(".is-open[data-dropdown-panel]").forEach(function (p) {
          p.classList.remove("is-open");
        });
        if (!isOpen) panel.classList.add("is-open");
      }
      return;
    }
    if (!e.target.closest("[data-dropdown-panel]")) {
      document.querySelectorAll(".is-open[data-dropdown-panel]").forEach(function (p) {
        p.classList.remove("is-open");
      });
    }
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      document.querySelectorAll(".is-open[data-dropdown-panel]").forEach(function (p) {
        p.classList.remove("is-open");
      });
    }
  });

  /* ---------- Tabs ---------- */
  document.addEventListener("click", function (e) {
    var tab = e.target.closest("[data-tab]");
    if (!tab) return;
    var group = tab.closest("[data-tabs]");
    if (!group) return;
    group.querySelectorAll("[data-tab]").forEach(function (t) {
      t.setAttribute("aria-selected", "false");
    });
    tab.setAttribute("aria-selected", "true");
    var target = tab.getAttribute("data-tab");
    group.querySelectorAll("[data-tab-panel]").forEach(function (panel) {
      panel.hidden = panel.getAttribute("data-tab-panel") !== target;
    });
  });

  /* ---------- Sidebar collapse + mobile ---------- */
  var shell = document.querySelector(".app-shell");
  if (shell) {
    var collapsed = localStorage.getItem("sidebar-collapsed") === "1";
    shell.setAttribute("data-collapsed", collapsed ? "true" : "false");

    document.addEventListener("click", function (e) {
      if (e.target.closest("[data-sidebar-trigger]")) {
        if (window.innerWidth < 768) {
          var mobileOpen = shell.getAttribute("data-mobile-open") === "true";
          shell.setAttribute("data-mobile-open", mobileOpen ? "false" : "true");
        } else {
          var next = shell.getAttribute("data-collapsed") !== "true";
          shell.setAttribute("data-collapsed", next ? "true" : "false");
          localStorage.setItem("sidebar-collapsed", next ? "1" : "0");
        }
        return;
      }
      if (e.target.closest("[data-sidebar-overlay]")) {
        shell.setAttribute("data-mobile-open", "false");
      }
    });
  }

  /* ---------- Toast ---------- */
  function dismissToast(el) {
    el.style.opacity = "0";
    el.style.transform = "translateY(0.5rem)";
    setTimeout(function () {
      el.remove();
    }, 200);
  }

  function initToast(el) {
    var timer = setTimeout(function () {
      dismissToast(el);
    }, 5000);
    el.addEventListener("click", function (e) {
      if (e.target.closest(".toast__close")) {
        clearTimeout(timer);
        dismissToast(el);
      }
    });
  }

  document.querySelectorAll(".toast").forEach(initToast);

  window.toast = function (message, variant) {
    var container = document.querySelector(".toast-container");
    if (!container) {
      container = document.createElement("div");
      container.className = "toast-container";
      document.body.appendChild(container);
    }
    variant = variant || "success";
    var el = document.createElement("div");
    el.className = "toast toast--" + variant;
    el.innerHTML =
      '<svg class="toast__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
      (variant === "error"
        ? '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
        : '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>') +
      "</svg>" +
      '<span class="toast__body">' + message + "</span>" +
      '<button type="button" class="toast__close" aria-label="Dismiss"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
    container.appendChild(el);
    initToast(el);
  };

  /* ---------- Combobox ---------- */
  document.querySelectorAll("[data-combobox]").forEach(function (root) {
    var trigger = root.querySelector(".combobox__trigger");
    var panel = root.querySelector(".combobox__panel");
    var searchInput = root.querySelector(".combobox__search input");
    var list = root.querySelector(".combobox__list");
    var src = root.getAttribute("data-src");
    var staticOptions = null;

    try {
      var staticAttr = root.getAttribute("data-options");
      if (staticAttr) staticOptions = JSON.parse(staticAttr);
    } catch (err) {
      staticOptions = null;
    }

    function close() {
      root.classList.remove("is-open");
    }
    function open() {
      root.classList.add("is-open");
      if (searchInput) searchInput.focus();
    }

    function renderOptions(options) {
      list.innerHTML = "";
      if (!options || options.length === 0) {
        var empty = document.createElement("div");
        empty.className = "combobox__empty";
        empty.textContent = "No results found.";
        list.appendChild(empty);
        return;
      }
      options.forEach(function (opt) {
        var row = document.createElement("div");
        row.className = "combobox__option";
        row.setAttribute("role", "option");
        row.innerHTML =
          '<span><span class="combobox__option-label">' + opt.label + "</span>" +
          (opt.description ? '<div class="combobox__option-desc">' + opt.description + "</div>" : "") +
          "</span>" +
          '<svg class="check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        row.addEventListener("click", function () {
          root.dispatchEvent(new CustomEvent("combobox:select", { detail: opt, bubbles: true }));
          close();
          if (searchInput) searchInput.value = "";
        });
        list.appendChild(row);
      });
    }

    function search(term) {
      if (staticOptions) {
        var filtered = staticOptions.filter(function (o) {
          return o.label.toLowerCase().indexOf(term.toLowerCase()) !== -1;
        });
        renderOptions(filtered);
        return;
      }
      if (!src) return;
      fetch(src, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "term=" + encodeURIComponent(term) + "&_csrf_token=" + encodeURIComponent(window.csrfToken || ""),
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
          renderOptions(data);
        })
        .catch(function () {
          renderOptions([]);
        });
    }

    if (trigger) {
      trigger.addEventListener("click", function () {
        if (root.classList.contains("is-open")) {
          close();
        } else {
          open();
          search("");
        }
      });
    }
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        search(searchInput.value);
      });
    }
    document.addEventListener("click", function (e) {
      if (!root.contains(e.target)) close();
    });
  });

  /* ---------- Table sort (client-side) ---------- */
  document.addEventListener("click", function (e) {
    var th = e.target.closest("[data-sort]");
    if (!th) return;
    var table = th.closest("table");
    if (!table) return;
    var tbody = table.querySelector("tbody");
    var index = Array.prototype.indexOf.call(th.parentNode.children, th);
    var current = th.getAttribute("data-sort-dir") || "none";
    var next = current === "asc" ? "desc" : current === "desc" ? "none" : "asc";

    table.querySelectorAll("[data-sort]").forEach(function (h) {
      h.removeAttribute("data-sort-dir");
    });

    if (next === "none") return;
    th.setAttribute("data-sort-dir", next);

    var rows = Array.prototype.slice.call(tbody.querySelectorAll("tr"));
    rows.sort(function (a, b) {
      var av = (a.children[index] && a.children[index].getAttribute("data-value")) || a.children[index].textContent.trim();
      var bv = (b.children[index] && b.children[index].getAttribute("data-value")) || b.children[index].textContent.trim();
      var an = parseFloat(av);
      var bn = parseFloat(bv);
      var cmp;
      if (!isNaN(an) && !isNaN(bn)) {
        cmp = an - bn;
      } else {
        cmp = av.localeCompare(bv);
      }
      return next === "asc" ? cmp : -cmp;
    });
    rows.forEach(function (row) {
      tbody.appendChild(row);
    });
  });

  /* ---------- File upload dropzone ---------- */
  document.querySelectorAll("[data-file-upload]").forEach(function (zone) {
    var input = zone.querySelector('input[type="file"]');
    var chipContainer = zone.querySelector("[data-file-upload-chip]");
    var promptEl = zone.querySelector("[data-file-upload-prompt]");

    function showChip(file) {
      if (!chipContainer) return;
      var sizeKb = Math.round(file.size / 1024);
      chipContainer.innerHTML =
        '<div class="file-upload__chip">' +
        '<svg class="file-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>' +
        '<span class="file-upload__chip-name">' + file.name + '</span>' +
        '<span class="file-upload__chip-size">' + sizeKb + ' KB</span>' +
        '<button type="button" class="file-upload__chip-remove" aria-label="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>' +
        '</div>';
      chipContainer.hidden = false;
      if (promptEl) promptEl.hidden = true;
    }

    function clearChip() {
      if (chipContainer) {
        chipContainer.innerHTML = "";
        chipContainer.hidden = true;
      }
      if (promptEl) promptEl.hidden = false;
      if (input) input.value = "";
    }

    // The dropzone is a <label> wrapping the file input, so a plain click
    // already opens the picker natively; only intercept the remove button.
    zone.addEventListener("click", function (e) {
      if (e.target.closest(".file-upload__chip-remove")) {
        e.preventDefault();
        clearChip();
      }
    });

    if (input) {
      input.addEventListener("change", function () {
        if (input.files && input.files[0]) showChip(input.files[0]);
      });
    }

    ["dragenter", "dragover"].forEach(function (evt) {
      zone.addEventListener(evt, function (e) {
        e.preventDefault();
        zone.classList.add("is-dragover");
      });
    });
    ["dragleave", "drop"].forEach(function (evt) {
      zone.addEventListener(evt, function (e) {
        e.preventDefault();
        zone.classList.remove("is-dragover");
      });
    });
    zone.addEventListener("drop", function (e) {
      if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0] && input) {
        input.files = e.dataTransfer.files;
        showChip(e.dataTransfer.files[0]);
      }
    });
  });

  /* ---------- Confirm dialog ---------- */
  document.addEventListener("submit", function (e) {
    var form = e.target;
    if (!form.matches("[data-confirm]")) return;
    if (form.getAttribute("data-confirmed") === "1") return;
    e.preventDefault();
    var message = form.getAttribute("data-confirm") || "Are you sure?";
    var dlg = document.getElementById("confirm-dialog");
    if (!dlg) {
      // Fallback if the shared confirm dialog markup isn't present.
      if (window.confirm(message)) {
        form.setAttribute("data-confirmed", "1");
        form.submit();
      }
      return;
    }
    dlg.querySelector("[data-confirm-message]").textContent = message;
    var okBtn = dlg.querySelector("[data-confirm-ok]");
    var onOk = function () {
      dlg.close();
      form.setAttribute("data-confirmed", "1");
      okBtn.removeEventListener("click", onOk);
      form.submit();
    };
    okBtn.addEventListener("click", onOk);
    dlg.showModal();
  });
})();
