/*
 * Order/Sales create-dialog behavior: SearchableCombobox selects a medicine,
 * then price/quantity/date panel appears with live total + stock/date validation.
 * Mirrors the ported logic from the old orders/create.php and sales/create.php inline jQuery.
 */
(function () {
  "use strict";

  function setupTransactionForm(formId) {
    var form = document.getElementById(formId);
    if (!form) return;

    var panel = form.querySelector('[data-txn-panel]');
    var nameEl = form.querySelector('[data-txn-name]');
    var priceEl = form.querySelector('[data-txn-price]');
    var totalEl = form.querySelector('[data-txn-total]');
    var quantityInput = form.querySelector('[name="quantity"]');
    var dateInput = form.querySelector('[data-txn-date]');
    var mIdInput = form.querySelector('[name="m_id"]');
    var submitBtn = form.querySelector('[data-txn-submit]');
    var quantityWarning = form.querySelector('[data-txn-quantity-warning]');
    var dateWarning = form.querySelector('[data-txn-date-warning]');
    var unitPrice = 0;

    function recompute() {
      var quantity = parseInt(quantityInput.value, 10) || 0;
      var maxStock = parseInt(quantityInput.getAttribute('max'), 10) || 0;
      totalEl.textContent = '$' + (unitPrice * quantity).toFixed(2);

      var stockOk = quantity >= 1 && quantity <= maxStock;
      quantityWarning.textContent = stockOk ? '' : 'Quantity exceeds available stock.';

      var dateOk = true;
      if (dateInput) {
        var selected = new Date(dateInput.value);
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        dateOk = dateInput.value !== '' && selected >= today;
        dateWarning.textContent = dateOk ? '' : 'Date cannot be in the past.';
      }

      submitBtn.disabled = !(stockOk && dateOk);
    }

    form.addEventListener('combobox:select', function (e) {
      var opt = e.detail;
      mIdInput.value = opt.m_id;
      unitPrice = opt.sell_price;
      nameEl.textContent = opt.label;
      priceEl.textContent = '$' + opt.sell_price.toFixed(2);
      quantityInput.value = 1;
      quantityInput.setAttribute('max', opt.in_stock);
      if (dateInput && !dateInput.value) {
        dateInput.value = new Date().toISOString().slice(0, 10);
      }
      panel.hidden = false;
      recompute();
    });

    if (quantityInput) quantityInput.addEventListener('input', recompute);
    if (dateInput) dateInput.addEventListener('input', recompute);
  }

  document.addEventListener('DOMContentLoaded', function () {
    setupTransactionForm('order-create-form');
    setupTransactionForm('sale-create-form');
  });
})();
