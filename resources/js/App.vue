<template>
    <SuggestionForm :form="form" />
</template>

<script setup>
import SuggestionForm from "./form/SuggestionForm.vue";

defineProps({
  form: Object
});
</script>
