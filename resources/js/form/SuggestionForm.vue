<template>
    <div class="min-h-screen flex justify-center mx-auto p-6">
        <div class="w-full max-w-xl flex flex-col space-y-2 text-foreground">

            <div v-if="form?.img_url" class="border border-border rounded overflow-hidden">
                <img :src="form.img_url" alt="" class="w-full h-34 object-cover" />
            </div>


            <form class="space-y-2" @submit.prevent="submitForm">
                <div class="bg-white border border-border rounded">
                    <div class="px-6 py-4 space-y-2">
                        <h1 class="text-2xl font-medium">
                            {{ form.title }}
                        </h1>
                        <p v-if="form?.description" class="text-sm font-normal">
                            {{ form.description }}
                        </p>
                    </div>

                    <div class="border-y border-border px-6 py-4">
                        <span class="text-sm italic font-normal">
                            You logged in as
                            <span class="underline">{{ displayEmail }}</span>
                        </span>
                    </div>

                    <div class="py-4 px-6 flex items-center space-x-2 text-sm">
                        <input type="checkbox" v-model="anonymous" id="agree" class="cursor-pointer" />
                        <label for="agree" class="cursor-pointer">
                            Submit anonymously
                        </label>
                    </div>
                </div>

                <div class="bg-white border border-border rounded">
                    <div class="py-4 px-6">
                        <textarea v-model="suggestion" placeholder="Describe your suggestion"
                            class="w-full text-sm min-h-45 p-3 border-b border-border focus:outline-none resize-y"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm mt-8">
                    <button type="submit"
                        class="bg-primary hover:bg-primary/90 transition-all duration-300 rounded text-white py-1 px-4 cursor-pointer">
                        Submit
                    </button>
                    <button type="button" @click="clearForm" class="cursor-pointer hover:underline">
                        Clear
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

const { form, userEmail } = defineProps({
    form: Object,
    userEmail: String,
});

const suggestion = ref("");
const anonymous = ref(false);

const displayEmail = computed(() => {
  return userEmail && userEmail.trim() !== ""
    ? userEmail
    : "Guest";
});

const submitForm = () => {
    console.log({
        form_id: form.id,
        suggestion: suggestion.value,
        anonymous: anonymous.value,
    });
};

const clearForm = () => {
    suggestion.value = "";
    anonymous.value = false;
};
</script>

