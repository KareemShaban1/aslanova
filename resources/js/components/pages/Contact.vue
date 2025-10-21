<script setup>
import { ref } from 'vue';

const name = ref('');
const email = ref('');
const message = ref('');

const handleSubmit = () => {
    alert(`{{ $t('thankYouMessage', { name: name.value }) }}`);
};
</script>

<template>
    <div class="container mt-4">
        <h2>{{ $t('contactUs') }}</h2>
        <form @submit.prevent="handleSubmit" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">{{ $t('name') }}</label>
                <input v-model="name" type="text" class="form-control" id="name" :placeholder=" $t('name')" required />
                <div class="invalid-feedback">
                    {{ $t('enterName') }}
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ $t('email') }}</label>
                <input v-model="email" type="email" class="form-control" id="email" :placeholder="$t('email')" required />
                <div class="invalid-feedback">
                    {{ $t('enterValidEmail') }}
                </div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">{{ $t('message') }}</label>
                <textarea v-model="message" class="form-control" id="message" rows="3" :placeholder="$t('message')" required></textarea>
                <div class="invalid-feedback">
                    {{ $t('enterMessage') }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ $t('send') }}</button>
        </form>

        <!-- Empty element to create a space of 200px -->
        <div style="height: 200px;"></div>
    </div>
</template>
