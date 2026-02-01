import { createApp } from "vue";
import App from "./App.vue";

const el = document.getElementById("app");

const form = el.dataset.form ? JSON.parse(el.dataset.form) : null;
const userEmail = el.dataset.email || "";

createApp(App, { form, userEmail }).mount("#app");
