const expressionEl = document.getElementById("expression");
const resultEl = document.getElementById("result");
const calculator = document.querySelector(".calculator");

let expression = "";
let justEvaluated = false;
let lastPreviewResult = null;

const operatorPattern = /[+\-*/]/;

function updateDisplay() {
  expressionEl.textContent = expression ? formatExpression(expression) : "0";
}

function formatExpression(value) {
  return value.replace(/\*/g, "×").replace(/\//g, "÷");
}

function getLastNumberDetails() {
  const match = expression.match(/(-?\d*\.?\d+(?:e[+\-]?\d+)?)$/i);
  if (!match) {
    return null;
  }

  const number = match[0];
  const index = expression.lastIndexOf(number);
  return { number, index };
}

function appendNumber(value) {
  if (justEvaluated) {
    expression = "";
    justEvaluated = false;
  }

  if (value === ".") {
    if (expression.slice(-1) === ".") {
      return;
    }
    const lastDetails = getLastNumberDetails();
    const lastNumber = lastDetails ? lastDetails.number : "";
    if (lastNumber.toLowerCase().includes("e")) {
      return;
    }
    if (lastNumber.includes(".")) {
      return;
    }

    if (!lastNumber) {
      if (!expression || operatorPattern.test(expression.slice(-1))) {
        expression += "0.";
        updateDisplay();
        updatePreview();
        return;
      }
    }
  }

  expression += value;
  updateDisplay();
  updatePreview();
}

function appendOperator(operator) {
  if (!expression) {
    if (operator === "-") {
      expression = "-";
      updateDisplay();
    }
    return;
  }

  if (expression === "-" && operator !== "-") {
    return;
  }

  if (justEvaluated) {
    justEvaluated = false;
  }

  if (operatorPattern.test(expression.slice(-1))) {
    expression = expression.slice(0, -1) + operator;
  } else {
    expression += operator;
  }

  updateDisplay();
  updatePreview();
}

function clearAll() {
  expression = "";
  justEvaluated = false;
  lastPreviewResult = null;
  updateDisplay();
  resultEl.textContent = "0";
}

function clearEntry() {
  if (!expression) {
    return;
  }
  expression = expression.slice(0, -1);
  justEvaluated = false;
  updateDisplay();
  updatePreview();
}

function toggleSign() {
  const details = getLastNumberDetails();
  if (!details) {
    return;
  }

  const { number, index } = details;
  const toggled = number.startsWith("-") ? number.slice(1) : `-${number}`;
  expression =
    expression.slice(0, index) + toggled + expression.slice(index + number.length);
  updateDisplay();
  updatePreview();
}

function applyPercentage() {
  const details = getLastNumberDetails();
  if (!details) {
    return;
  }
  const { number, index } = details;
  const numericValue = parseFloat(number);
  if (Number.isNaN(numericValue)) {
    return;
  }

  const percentValue = numericValue / 100;
  const formatted = formatNumericString(percentValue);
  expression =
    expression.slice(0, index) + formatted + expression.slice(index + number.length);
  updateDisplay();
  updatePreview();
}

function sanitizeExpression(expr) {
  if (!expr || expr === "-") {
    return null;
  }

  let sanitized = expr;
  if (sanitized.endsWith(".")) {
    sanitized = sanitized.slice(0, -1);
  }

  if (!sanitized) {
    return null;
  }

  if (operatorPattern.test(sanitized.slice(-1))) {
    return null;
  }

  if (!/^[0-9eE+\-*/.]+$/.test(sanitized)) {
    return null;
  }

  return sanitized;
}

function evaluateExpression() {
  const sanitized = sanitizeExpression(expression);
  if (!sanitized) {
    return;
  }

  try {
    const result = Function(`"use strict"; return (${sanitized});`)();
    if (!Number.isFinite(result)) {
      resultEl.textContent = "Tanımsız";
      return;
    }

    const formatted = formatNumericString(result);
    resultEl.textContent = formatted;
    expression = formatted;
    justEvaluated = true;
    lastPreviewResult = result;
    updateDisplay();
  } catch (error) {
    resultEl.textContent = "Hata";
  }
}

function updatePreview() {
  const sanitized = sanitizeExpression(expression);
  if (!sanitized) {
    if (!expression) {
      resultEl.textContent = "0";
    } else if (lastPreviewResult !== null) {
      resultEl.textContent = formatNumericString(lastPreviewResult);
    } else {
      resultEl.textContent = "";
    }
    return;
  }

  try {
    const preview = Function(`"use strict"; return (${sanitized});`)();
    if (!Number.isFinite(preview)) {
      resultEl.textContent = "Tanımsız";
      lastPreviewResult = null;
      return;
    }
    lastPreviewResult = preview;
    resultEl.textContent = formatNumericString(preview);
  } catch (error) {
    resultEl.textContent = "";
    lastPreviewResult = null;
  }
}

function formatNumericString(value) {
  if (!Number.isFinite(value)) {
    return "Tanımsız";
  }

  const rounded = Number.parseFloat(value.toPrecision(12));
  if (Object.is(rounded, -0)) {
    return "0";
  }

  let text = rounded.toString();

  if (!text.includes("e")) {
    text = text.replace(/\.0+$/, "").replace(/(\.\d*?[1-9])0+$/, "$1");
  }

  return text;
}

function handleButton(event) {
  const button = event.currentTarget;
  const { type, value, action } = button.dataset;

  if (type === "number") {
    appendNumber(value);
    return;
  }

  if (type === "operator") {
    appendOperator(value);
    return;
  }

  if (action) {
    switch (action) {
      case "clear-all":
        clearAll();
        break;
      case "clear-entry":
        clearEntry();
        break;
      case "toggle-sign":
        toggleSign();
        break;
      case "percentage":
        applyPercentage();
        break;
      case "calculate":
        evaluateExpression();
        break;
      default:
        break;
    }
  }
}

function handleKeyboard(event) {
  const { key } = event;

  if (/^\d$/.test(key)) {
    appendNumber(key);
    return;
  }

  if (key === "." || key === ",") {
    event.preventDefault();
    appendNumber(".");
    return;
  }

  if (["+", "-", "*", "/"].includes(key)) {
    event.preventDefault();
    appendOperator(key);
    return;
  }

  if (key === "Enter" || key === "=") {
    event.preventDefault();
    evaluateExpression();
    return;
  }

  if (key === "Backspace") {
    event.preventDefault();
    clearEntry();
    return;
  }

  if (key === "Delete") {
    event.preventDefault();
    clearAll();
    return;
  }

  if (key.toLowerCase() === "%") {
    event.preventDefault();
    applyPercentage();
    return;
  }

  if (key === "Escape") {
    event.preventDefault();
    clearAll();
  }
}

calculator
  .querySelectorAll("button")
  .forEach((button) => button.addEventListener("click", handleButton));

document.addEventListener("keydown", handleKeyboard);

updateDisplay();
updatePreview();
