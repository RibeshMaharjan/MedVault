/*
 * Shared Chart.js styling to visually match the recharts look used by the
 * lovable design (dashed grid, no axis lines, teal/green/amber/blue/red series).
 */
(function () {
  "use strict";

  var COLORS = {
    primary: '#00848b',
    success: '#269e5f',
    warning: '#e1a035',
    info: '#338fc7',
    destructive: '#d73337',
    border: '#dae3e8',
    mutedFg: '#546673',
  };

  var gridOptions = {
    display: true,
    color: COLORS.border,
    drawTicks: false,
    borderDash: [3, 3],
  };

  var tickOptions = {
    color: COLORS.mutedFg,
    font: { size: 12 },
  };

  var tooltipOptions = {
    backgroundColor: '#ffffff',
    titleColor: '#0d1c27',
    bodyColor: '#0d1c27',
    borderColor: COLORS.border,
    borderWidth: 1,
    cornerRadius: 8,
    padding: 10,
    displayColors: false,
  };

  function baseScales(xVertical) {
    return {
      x: {
        grid: { display: !!xVertical, color: COLORS.border, borderDash: [3, 3], drawTicks: false },
        border: { display: false },
        ticks: tickOptions,
      },
      y: {
        grid: gridOptions,
        border: { display: false },
        ticks: tickOptions,
        beginAtZero: true,
      },
    };
  }

  function barConfig(labels, data, opts) {
    opts = opts || {};
    return {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: opts.color || COLORS.primary,
          borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 },
          borderSkipped: 'bottom',
          maxBarThickness: 40,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: tooltipOptions },
        scales: baseScales(false),
      },
    };
  }

  function lineConfig(labels, data, opts) {
    opts = opts || {};
    return {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          borderColor: opts.color || COLORS.primary,
          backgroundColor: 'transparent',
          borderWidth: 2.5,
          pointRadius: 0,
          cubicInterpolationMode: 'monotone',
          tension: 0.4,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: tooltipOptions },
        scales: baseScales(false),
      },
    };
  }

  function doughnutConfig(labels, data, colors) {
    return {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: colors,
          borderWidth: 0,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68.75%',
        plugins: {
          legend: { position: 'bottom', labels: { color: COLORS.mutedFg, usePointStyle: true, boxWidth: 8, font: { size: 12 } } },
          tooltip: tooltipOptions,
        },
      },
    };
  }

  window.chartTheme = {
    COLORS: COLORS,
    bar: barConfig,
    line: lineConfig,
    doughnut: doughnutConfig,
  };
})();
